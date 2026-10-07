<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->assertViewHas('secoes')
            ->assertViewHas('atualizacao', 'Setembro de 2026');
    }

    public function test_pagina_mostra_os_documentos(): void
    {
        $this->get(route('transparencia'))
            ->assertSee('Estatuto Social consolidado')
            ->assertSee('Prestação de contas')
            ->assertSee('Em elaboração');
    }
}