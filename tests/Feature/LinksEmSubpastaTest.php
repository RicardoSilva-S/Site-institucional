<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * No servidor do professor o site fica numa subpasta (/idtnpr). Link escrito
 * como href="/pagina" ignora a subpasta e cai fora do site; os links tem que
 * ser gerados por route() ou url().
 */
class LinksEmSubpastaTest extends TestCase
{
    use RefreshDatabase;

    public function test_paginas_nao_tem_link_com_caminho_fixo()
    {
        $paginas = ['/', '/institucional', '/atuacao', '/projetos', '/editais', '/marco-legal', '/contato', '/transparencia', '/politica-de-privacidade'];

        foreach ($paginas as $pagina) {
            $html = $this->get($pagina)->assertOk()->getContent();

            // href="/algo" (mas nao href="//cdn..." nem href="/" sozinho, que nao existem no site)
            $this->assertSame(0, preg_match('#(href|src|action)="/[^/"]#', $html), "$pagina tem link com caminho fixo");
        }
    }

    public function test_link_da_politica_no_contato_usa_a_rota()
    {
        $this->get('/contato')->assertSee('href="' . route('privacidade') . '"', false);
    }
}
