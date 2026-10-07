<?php

namespace Tests\Feature;

use App\Models\TransparenciaDocumento;
use App\Models\TransparenciaSecao;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TransparenciaPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_de_transparencia_abre(): void
    {
        $this->get(route('transparencia'))->assertOk();
    }

    public function test_controller_entrega_secoes_e_atualizacao_para_a_view(): void
    {
        $this->get(route('transparencia'))
            ->assertViewHas('secoes', function ($secoes) {
                return $secoes->count() === 5 && $secoes->sum(function ($secao) {
                    return $secao->documentos->count();
                }) === 18;
            })
            ->assertViewHas('atualizacao', function ($atualizacao) {
                return $atualizacao === Str::ucfirst(now()->locale('pt_BR')->isoFormat('MMMM [de] YYYY'));
            });
    }

    public function test_ultima_atualizacao_acompanha_o_documento_editado_mais_recente(): void
    {
        TransparenciaDocumento::query()->update(['updated_at' => '2025-03-10 10:00:00']);
        TransparenciaSecao::query()->update(['updated_at' => '2025-03-10 10:00:00']);
        TransparenciaDocumento::query()->whereKey(TransparenciaDocumento::min('id'))->update(['updated_at' => '2026-01-15 10:00:00']);

        $this->get(route('transparencia'))->assertViewHas('atualizacao', 'Janeiro de 2026');
    }

    public function test_pagina_mostra_os_documentos(): void
    {
        $this->get(route('transparencia'))
            ->assertSee('Estatuto Social consolidado')
            ->assertSee('Prestação de contas')
            ->assertSee('Em elaboração');
    }
}