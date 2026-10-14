<?php

namespace Tests\Feature;

use App\Models\SiteText;
use App\Models\User;
use App\Support\SiteContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Painel de textos do site (/adm/paginas/{page}, ContentController).
 * Alterar e incluir textos nas páginas Institucional e Atuação fica em
 * InstitucionalAtuacaoEditaveisTest.
 */
class PainelTextosTest extends TestCase
{
    use RefreshDatabase;

    private const TITULO_HOME = 'home.hero.title';

    private function editor(): User
    {
        return User::factory()->create(['papel' => User::PAPEL_EDITOR]);
    }

    private function texto(string $key): SiteText
    {
        return SiteText::where('key', $key)->firstOrFail();
    }

    public function test_sem_login_nao_acessa_o_painel_de_textos(): void
    {
        $this->get(route('admin.pages.show', 'home'))->assertRedirect(route('login'));
    }

    public function test_painel_mostra_os_textos_da_pagina(): void
    {
        $this->actingAs($this->editor())
            ->get(route('admin.pages.show', 'home'))
            ->assertOk()
            ->assertSee($this->texto(self::TITULO_HOME)->value);
    }

    public function test_pagina_que_nao_existe_da_404(): void
    {
        $this->actingAs($this->editor())
            ->get(route('admin.pages.show', 'pagina-que-nao-existe'))
            ->assertNotFound();
    }

    public function test_excluir_texto_original_so_esvazia_e_restaurar_traz_de_volta(): void
    {
        $titulo = $this->texto(self::TITULO_HOME);
        $original = SiteContent::defaults()[self::TITULO_HOME];

        $this->actingAs($this->editor())
            ->delete(route('admin.texts.destroy', $titulo))
            ->assertRedirect(route('admin.pages.show', 'home'));

        // Texto original não é apagado da tabela: só fica vazio (some do site).
        $this->assertDatabaseHas('site_texts', ['id' => $titulo->id, 'value' => '']);
        $this->get(route('home'))->assertDontSee($original);

        $this->post(route('admin.texts.restore', $titulo))
            ->assertRedirect(route('admin.pages.show', 'home'));

        $this->assertSame($original, $titulo->fresh()->value);
        $this->get(route('home'))->assertSee($original);
    }

    public function test_texto_incluido_pelo_painel_nao_tem_original_para_restaurar(): void
    {
        $this->actingAs($this->editor())->post(route('admin.texts.store', 'home'), [
            'group' => 'hero',
            'label' => 'Aviso extra',
            'value' => 'Texto incluído no teste',
        ]);

        $incluido = SiteText::where('label', 'Aviso extra')->firstOrFail();

        $this->post(route('admin.texts.restore', $incluido))->assertNotFound();
    }

    public function test_nao_deixa_incluir_texto_solto_no_menu(): void
    {
        $this->actingAs($this->editor())
            ->post(route('admin.texts.store', 'shared'), [
                'group' => 'nav',
                'label' => 'Item novo',
                'value' => 'Não deveria entrar',
            ])
            ->assertStatus(422);

        $this->assertDatabaseMissing('site_texts', ['label' => 'Item novo']);
    }

    public function test_salvar_uma_pagina_nao_altera_textos_de_outra(): void
    {
        $titulo = $this->texto(self::TITULO_HOME);
        $deOutraPagina = SiteText::where('page', '!=', 'home')->firstOrFail();
        $valorAntes = $deOutraPagina->value;

        // Alguém manda, no formulário da Home, o id de um texto de outra página.
        $this->actingAs($this->editor())->put(route('admin.pages.update', 'home'), [
            'texts' => [
                $titulo->id => 'Título novo da Home',
                $deOutraPagina->id => 'Alterado por fora',
            ],
        ]);

        $this->assertSame('Título novo da Home', $titulo->fresh()->value);
        $this->assertSame($valorAntes, $deOutraPagina->fresh()->value);
    }

    public function test_salvar_sem_mandar_textos_mostra_erro(): void
    {
        $this->actingAs($this->editor())
            ->from(route('admin.pages.show', 'home'))
            ->put(route('admin.pages.update', 'home'), [])
            ->assertSessionHasErrors('texts');
    }
}
