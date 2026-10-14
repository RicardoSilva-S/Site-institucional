<?php

namespace Tests\Feature;

use App\Models\ManifestacaoOuvidoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OuvidoriaTest extends TestCase
{
    use RefreshDatabase;

    private function dados(array $extra = []): array
    {
        return array_merge([
            'tipo' => 'sugestao',
            'nome' => 'Carlos Lima',
            'email' => 'carlos@example.com',
            'telefone' => '44999990000',
            'mensagem' => 'Sugiro horario estendido no atendimento.',
        ], $extra);
    }

    public function test_pagina_de_contato_mostra_o_formulario_da_ouvidoria()
    {
        $this->get('/contato')->assertOk()->assertSee(route('ouvidoria.enviar'), false);
    }

    public function test_manifestacao_e_gravada_e_devolve_protocolo()
    {
        $this->post('/ouvidoria', $this->dados())
            ->assertRedirect(route('contato') . '#ouvidoria')
            ->assertSessionHas('ouvidoria_protocolo');

        $manifestacao = ManifestacaoOuvidoria::firstOrFail();
        $this->assertSame('Carlos Lima', $manifestacao->nome);
        $this->assertSame('OUV-' . now()->year . '-00001', $manifestacao->protocolo());
        $this->assertFalse($manifestacao->estaRespondida());
    }

    public function test_manifestacao_anonima_nao_guarda_dados_pessoais()
    {
        $this->post('/ouvidoria', $this->dados(['anonimo' => '1', 'tipo' => 'denuncia']))
            ->assertSessionHasNoErrors();

        $manifestacao = ManifestacaoOuvidoria::firstOrFail();
        $this->assertTrue($manifestacao->anonimo);
        $this->assertNull($manifestacao->nome);
        $this->assertNull($manifestacao->email);
        $this->assertNull($manifestacao->telefone);
    }

    public function test_campos_obrigatorios_e_tipo_invalido()
    {
        $this->post('/ouvidoria', ['tipo' => 'qualquer'])
            ->assertSessionHasErrors(['tipo', 'nome', 'mensagem']);

        $this->assertDatabaseCount('manifestacoes_ouvidoria', 0);
    }

    public function test_anonimo_nao_precisa_de_nome()
    {
        $this->post('/ouvidoria', $this->dados(['anonimo' => '1', 'nome' => '']))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('manifestacoes_ouvidoria', 1);
    }

    public function test_painel_lista_e_marca_como_respondida()
    {
        $manifestacao = ManifestacaoOuvidoria::create($this->dados());

        $this->get('/adm/ouvidoria')->assertRedirect(route('login'));

        $admin = User::factory()->create();
        $this->actingAs($admin)->get('/adm/ouvidoria')
            ->assertOk()
            ->assertSee($manifestacao->protocolo())
            ->assertSee('1 aguardando resposta');

        $this->actingAs($admin)->post("/adm/ouvidoria/{$manifestacao->id}/status")->assertRedirect();
        $this->assertTrue($manifestacao->fresh()->estaRespondida());
    }
}
