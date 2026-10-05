<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $override = []): array
    {
        return array_merge([
            'nome' => 'Maria Souza',
            'cargo' => 'Procuradora',
            'orgao' => 'Prefeitura de Sarandi',
            'email' => 'maria@exemplo.gov.br',
            'telefone' => '(44) 99999-0000',
            'area' => 'Atendimento ao cidadão',
            'mensagem' => 'Precisamos de um diagnóstico do atendimento.',
        ], $override);
    }

    public function test_pagina_de_contato_carrega_com_formulario_apontando_para_a_rota(): void
    {
        $this->get(route('contato'))
            ->assertOk()
            ->assertSee(route('contato.enviar'), false);
    }

    public function test_envio_valido_grava_a_mensagem_e_avisa_por_email(): void
    {
        Mail::fake();

        $this->post(route('contato.enviar'), $this->payload())
            ->assertRedirect(route('contato').'#diagnostico')
            ->assertSessionHas('contact_status');

        $this->assertDatabaseHas('contact_messages', [
            'nome' => 'Maria Souza',
            'orgao' => 'Prefeitura de Sarandi',
            'email' => 'maria@exemplo.gov.br',
        ]);

        Mail::assertSent(ContactMessageReceived::class, function ($mail) {
            return $mail->hasTo(config('mail.contact_to'))
                && $mail->hasReplyTo('maria@exemplo.gov.br');
        });
    }

    public function test_email_de_aviso_renderiza_com_os_dados_da_mensagem(): void
    {
        $message = ContactMessage::create($this->payload(['mensagem' => 'Texto com & e <b>tags</b>']));

        $body = (new ContactMessageReceived($message))->render();

        $this->assertStringContainsString('Maria Souza', $body);
        $this->assertStringContainsString('Prefeitura de Sarandi', $body);
        $this->assertStringContainsString('Texto com & e <b>tags</b>', $body);
    }

    public function test_campos_obrigatorios_sao_validados(): void
    {
        $this->post(route('contato.enviar'), [])
            ->assertSessionHasErrors(['nome', 'orgao', 'mensagem']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_email_e_area_invalidos_sao_recusados(): void
    {
        $this->post(route('contato.enviar'), $this->payload(['email' => 'nao-e-email', 'area' => 'Qualquer coisa']))
            ->assertSessionHasErrors(['email', 'area']);
    }

    public function test_email_e_area_sao_opcionais(): void
    {
        Mail::fake();

        $this->post(route('contato.enviar'), $this->payload(['email' => '', 'area' => '', 'cargo' => '', 'telefone' => '']))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('contact_messages', 1);
    }

    public function test_campo_isca_preenchido_nao_grava_nem_envia_email(): void
    {
        Mail::fake();

        $this->post(route('contato.enviar'), $this->payload(['website' => 'http://spam.example']))
            ->assertRedirect();

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_falha_no_email_nao_perde_a_mensagem(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('smtp fora do ar'));

        $this->post(route('contato.enviar'), $this->payload())
            ->assertSessionHas('contact_status');

        $this->assertDatabaseCount('contact_messages', 1);
    }

    public function test_limite_de_envios_por_minuto(): void
    {
        Mail::fake();

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('contato.enviar'), $this->payload())->assertRedirect();
        }

        $this->post(route('contato.enviar'), $this->payload())->assertStatus(429);
    }

    public function test_painel_de_mensagens_exige_login(): void
    {
        $this->get(route('admin.messages.index'))->assertRedirect(route('login'));
    }

    public function test_painel_lista_e_marca_como_lida(): void
    {
        $message = ContactMessage::create($this->payload());
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSee('Maria Souza')
            ->assertSee('1 não lida');

        $this->actingAs($user)
            ->post(route('admin.messages.toggle-read', $message))
            ->assertRedirect();

        $this->assertTrue($message->fresh()->isRead());
    }
}
