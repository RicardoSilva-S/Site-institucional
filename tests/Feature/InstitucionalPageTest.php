<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\SiteText;
use App\Models\User;
use App\Support\BannerSlots;
use App\Support\SiteContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstitucionalPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_topo_mostra_a_ficha_e_a_imagem_padrao()
    {
        $this->get('/institucional')
            ->assertOk()
            ->assertSee('assets/institucional/hero.svg')
            ->assertSee('Natureza jurídica')
            ->assertSee('Julho de 2025');
    }

    public function test_imagem_do_topo_pode_ser_trocada_no_painel()
    {
        $this->assertSame('assets/institucional/hero.svg', BannerSlots::fallback('institucional', 'hero'));
        $this->assertArrayHasKey('institucional:hero', BannerSlots::options()['Institucional']);

        $this->actingAs(User::factory()->create())
            ->get('/adm/paginas/institucional')
            ->assertOk()
            ->assertSee('Imagem da seção')
            ->assertSee('assets/institucional/hero.svg')
            ->assertSee('Trocar imagem');
    }

    public function test_banner_cadastrado_substitui_a_imagem_do_topo()
    {
        Banner::create(['page' => 'institucional', 'slot' => 'hero', 'image' => 'uploads/banners/topo.jpg', 'active' => true]);

        $this->get('/institucional')
            ->assertSee('uploads/banners/topo.jpg')
            ->assertDontSee('assets/institucional/hero.svg');
    }

    public function test_principios_aparecem_um_por_etiqueta()
    {
        $this->get('/institucional')
            ->assertSee('<li>Legalidade</li>', false)
            ->assertSee('<li>Interesse público</li>', false);
    }

    public function test_passo_excluido_no_painel_some_da_linha_do_tempo()
    {
        SiteContent::sync();
        SiteText::query()
            ->whereIn('key', ['institucional.passo3.title', 'institucional.passo3.text'])
            ->update(['value' => '']);
        SiteContent::forget();

        $this->get('/institucional')
            ->assertDontSee('Jan · 2026')
            ->assertSee('Set · 2025')
            ->assertSee('Ago · 2026');
    }

    public function test_lista_de_documentos_abre_a_secao_do_portal()
    {
        $this->get('/institucional')
            ->assertSee(route('transparencia').'#normativos', false)
            ->assertSee(route('transparencia').'#contas', false);
    }
}
