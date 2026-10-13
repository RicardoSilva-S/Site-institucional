<?php

namespace Tests\Feature;

use App\Models\SiteText;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TextosProjetosEditaisPrivacidadeTest extends TestCase
{
    use RefreshDatabase;

    public function test_paginas_mostram_os_textos_originais()
    {
        $this->get('/projetos')->assertOk()->assertSee('Projetos pensados para produzir resultado público.');
        $this->get('/editais')->assertOk()->assertSee('Da qualificação à homologação, em quatro etapas');
        $this->get('/politica-de-privacidade')->assertOk()->assertSee('Quais dados coletamos');
    }

    public function test_paginas_aparecem_no_painel()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get('/adm/paginas/projetos')->assertOk()->assertSee('Impacto e alcance');
        $this->actingAs($admin)->get('/adm/paginas/editais')->assertOk()->assertSee('Quadro de avisos');
        $this->actingAs($admin)->get('/adm/paginas/privacidade')->assertOk()->assertSee('Seus direitos');
    }

    public function test_texto_alterado_no_painel_aparece_no_site()
    {
        $admin = User::factory()->create();

        // abrir a pagina no painel copia os textos do config para o banco
        $this->actingAs($admin)->get('/adm/paginas/privacidade');
        $data = SiteText::query()->where('key', 'privacidade.hero.atualizacao')->firstOrFail();

        $this->actingAs($admin)
            ->put('/adm/paginas/privacidade', ['texts' => [$data->id => 'Última atualização: novembro de 2026']])
            ->assertRedirect();

        $this->get('/politica-de-privacidade')->assertSee('Última atualização: novembro de 2026');
    }

    public function test_titulo_dos_editais_continua_com_o_ano()
    {
        $this->get('/editais')->assertSee('Chamamentos públicos de ' . now()->year);
    }
}
