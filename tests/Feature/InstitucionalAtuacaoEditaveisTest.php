<?php

namespace Tests\Feature;

use App\Models\SiteText;
use App\Models\User;
use App\Support\SiteContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstitucionalAtuacaoEditaveisTest extends TestCase
{
    use RefreshDatabase;

    public function test_paginas_mostram_os_textos_originais()
    {
        $this->get('/institucional')->assertOk()->assertSee('Como o Instituto chegou até aqui');
        $this->get('/atuacao')->assertOk()->assertSee('Capacitação de servidores');
    }

    public function test_paginas_aparecem_no_painel()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get('/adm/paginas/institucional')->assertOk()->assertSee('Nossa história');
        $this->actingAs($admin)->get('/adm/paginas/atuacao')->assertOk()->assertSee('Capacitação de servidores');
    }

    public function test_texto_alterado_no_painel_aparece_no_site()
    {
        $admin = User::factory()->create();

        // abrir a pagina no painel copia os textos do config para o banco
        $this->actingAs($admin)->get('/adm/paginas/institucional');
        $titulo = SiteText::query()->where('key', 'institucional.historia.title')->firstOrFail();

        $this->actingAs($admin)
            ->put('/adm/paginas/institucional', ['texts' => [$titulo->id => 'Nossa trajetória']])
            ->assertRedirect();

        $this->get('/institucional')->assertSee('Nossa trajetória')->assertDontSee('Como o Instituto chegou até aqui');
    }

    public function test_texto_incluido_no_painel_aparece_na_secao()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post('/adm/paginas/atuacao/textos', [
                'group' => 'piloto',
                'label' => 'Aviso',
                'value' => 'Novo piloto em andamento.',
            ])
            ->assertRedirect();

        $this->get('/atuacao')->assertSee('Novo piloto em andamento.');
    }

    public function test_itens_da_atuacao_aparecem_com_frase_propria()
    {
        // O complemento ": inventário de dados..." aparece como frase solta.
        $this->get('/atuacao')
            ->assertSee('frente-itens', false)
            ->assertSee('Inventário de dados, bases legais, encarregado e relatório de impacto.')
            ->assertDontSee(': inventário de dados');
    }

    public function test_item_excluido_no_painel_some_da_lista()
    {
        SiteContent::sync();
        SiteText::query()
            ->whereIn('key', ['atuacao.governanca.item2.title', 'atuacao.governanca.item2.text'])
            ->update(['value' => '']);
        SiteContent::forget();

        $this->get('/atuacao')
            ->assertDontSee('Mapeamento e redesenho de processos')
            ->assertSee('Políticas internas');
    }
}
