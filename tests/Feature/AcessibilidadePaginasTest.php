<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcessibilidadePaginasTest extends TestCase
{
    use RefreshDatabase;

    private const PAGINAS = ['/', '/institucional', '/marco-legal', '/atuacao', '/contato', '/transparencia'];

    public function test_titulos_das_seis_paginas_nao_pulam_nivel()
    {
        foreach (self::PAGINAS as $pagina) {
            $html = $this->get($pagina)->assertOk()->getContent();
            preg_match_all('/<h([1-6])[\s>]/', $html, $niveis);

            $anterior = 1;
            foreach ($niveis[1] as $nivel) {
                $this->assertLessThanOrEqual($anterior + 1, (int) $nivel, "$pagina: pulou de h$anterior para h$nivel");
                $anterior = (int) $nivel;
            }
        }
    }

    public function test_botao_do_menu_aponta_para_a_navegacao()
    {
        foreach (self::PAGINAS as $pagina) {
            $this->get($pagina)
                ->assertOk()
                ->assertSee('id="menu-principal"', false)
                ->assertSee('aria-controls="menu-principal"', false);
        }
    }
}
