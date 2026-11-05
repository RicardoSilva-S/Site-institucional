<?php

namespace Tests\Feature;

use App\Models\SiteText;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menu, atalhos, cabeçalhos de tabela e botões de WhatsApp/e-mail ficam
 * escritos nas páginas e não aparecem mais no painel.
 */
class TextosFixosTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_e_atalhos_continuam_no_site(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Transparência')
            ->assertSee('Fale com o Instituto');

        $this->get('/institucional')->assertSee('Quem somos');
        $this->get('/atuacao')->assertSee('Piloto e PD&amp;I', false);
        $this->get('/editais')->assertSee('Chamamentos públicos de ' . now()->year);
    }

    public function test_textos_fixos_nao_aparecem_no_painel(): void
    {
        $editor = User::factory()->create(['papel' => User::PAPEL_EDITOR]);

        $this->actingAs($editor)->get('/adm/paginas/shared')
            ->assertOk()
            ->assertDontSee('Item do menu')
            ->assertSee('Texto sobre o Instituto');

        $this->actingAs($editor)->get('/adm/paginas/atuacao')
            ->assertOk()
            ->assertDontSee('Atalho — Frente 01');

        $this->assertSame(0, SiteText::where('key', 'like', '%.nav.%')->count());
    }
}