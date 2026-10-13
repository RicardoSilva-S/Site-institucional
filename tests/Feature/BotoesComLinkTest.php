<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BotoesComLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_botoes_da_home_levam_para_as_paginas()
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('contato') . '#diagnostico', false)
            ->assertSee(route('projetos'), false)
            ->assertSee(route('atuacao'), false)
            ->assertSee(route('transparencia'), false);
    }

    public function test_botao_de_editais_da_transparencia()
    {
        $this->get('/transparencia')->assertOk()->assertSee(route('editais'), false);
    }

    public function test_nenhum_botao_sem_destino_nas_paginas()
    {
        foreach (['/', '/transparencia'] as $pagina) {
            $this->assertStringNotContainsString('href="#"', $this->get($pagina)->getContent(), $pagina);
        }
    }
}
