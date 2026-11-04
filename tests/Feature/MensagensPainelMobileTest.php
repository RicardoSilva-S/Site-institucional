<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tela /adm/mensagens aberta no celular.
 *
 * Trava o que foi conferido no navegador com 360px de largura: a lista não
 * passa da largura da tela por causa de um e-mail comprido e a mensagem já
 * lida continua legível.
 */
class MensagensPainelMobileTest extends TestCase
{
    use RefreshDatabase;

    private function css(): string
    {
        return str_replace(' ', '', (string) file_get_contents(public_path('css/admin.css')));
    }

    public function test_mensagem_com_email_comprido_aparece_na_tela()
    {
        $admin = User::factory()->create();

        ContactMessage::create([
            'nome' => 'Maria Aparecida de Souza Lima',
            'orgao' => 'Prefeitura Municipal de Sarandi',
            'cargo' => 'Secretária Municipal de Administração e Planejamento',
            'email' => 'maria.aparecida.souza@sarandi.pr.gov.br',
            'mensagem' => 'Gostaríamos de agendar uma apresentação das soluções.',
        ]);

        $this->actingAs($admin)
            ->get('/adm/mensagens')
            ->assertOk()
            ->assertSee('maria.aparecida.souza@sarandi.pr.gov.br')
            ->assertSee('Marcar como lida');
    }

    public function test_lista_nao_estica_com_o_conteudo_mais_largo()
    {
        $css = $this->css();

        // Sem o minmax(0,...) a coluna do grid cresce até caber o e-mail
        // inteiro e a lista passa da largura do aparelho.
        $this->assertMatchesRegularExpression(
            '/\.admin-messages\{[^}]*grid-template-columns:minmax\(0,1fr\)/',
            $css
        );
        $this->assertMatchesRegularExpression(
            '/\.msg-fieldsdd\{[^}]*overflow-wrap:anywhere/',
            $css
        );
    }

    public function test_mensagem_lida_nao_perde_contraste()
    {
        // opacity clareia junto o texto da mensagem; a marca de lida é a
        // barra lateral apagada.
        $this->assertDoesNotMatchRegularExpression(
            '/\.msg-card\.is-read\{[^}]*opacity/',
            $this->css()
        );
    }

    public function test_botao_de_marcar_ocupa_a_largura_no_celular()
    {
        $this->assertMatchesRegularExpression(
            '/\.msg-headform\.btn\{[^}]*width:100%/',
            $this->css()
        );
    }
}
