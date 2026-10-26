<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * E-mail com quebra de linha (CRLF) pode injetar cabecalhos no aviso por e-mail
 * (ex: "Bcc: ..."). A regra "email" do Laravel 8 deixa passar quebra de linha
 * dentro de comentario ou aspas, entao os formularios recusam qualquer \r ou \n.
 */
class EmailSemQuebraDeLinhaTest extends TestCase
{
    use RefreshDatabase;

    // a regra "email" sozinha ACEITA esses formatos (quebra de linha em comentario ou aspas)
    private const EMAIL_COM_CRLF = "maria(\r\n x)@example.com";
    private const EMAIL_COM_CRLF_ASPAS = "\"ma\r\n ria\"@example.com";

    public function test_contato_recusa_email_com_quebra_de_linha()
    {
        Mail::fake();

        $this->post(route('contato.enviar'), [
            'nome' => 'Maria',
            'orgao' => 'Prefeitura',
            'email' => self::EMAIL_COM_CRLF,
            'mensagem' => 'Teste',
        ])->assertSessionHasErrors('email');

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_ouvidoria_recusa_email_com_quebra_de_linha()
    {
        $this->post('/ouvidoria', [
            'tipo' => 'sugestao',
            'nome' => 'Carlos',
            'email' => self::EMAIL_COM_CRLF_ASPAS,
            'mensagem' => 'Teste',
        ])->assertSessionHasErrors('email');

        $this->assertDatabaseCount('manifestacoes_ouvidoria', 0);
    }

    public function test_cadastro_de_usuario_recusa_email_com_quebra_de_linha()
    {
        $admin = User::factory()->create(['papel' => User::PAPEL_ADMIN]);

        $this->actingAs($admin)->post('/adm/usuarios', [
            'name' => 'Novo',
            'email' => self::EMAIL_COM_CRLF,
            'papel' => 'editor',
            'password' => 'senha-forte-123',
            'password_confirmation' => 'senha-forte-123',
            'ativo' => '1',
        ])->assertSessionHasErrors('email');

        $this->assertSame(1, User::count());
    }

    public function test_email_normal_continua_aceito()
    {
        Mail::fake();

        $this->post(route('contato.enviar'), [
            'nome' => 'Maria',
            'orgao' => 'Prefeitura',
            'email' => 'maria@example.com',
            'mensagem' => 'Teste',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount('contact_messages', 1);
    }
}
