<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RodapeTest extends TestCase
{
    use RefreshDatabase;

    private function rodape(): string
    {
        $html = $this->get('/')->assertOk()->getContent();

        return substr($html, strpos($html, '<footer>'), strpos($html, '</footer>') - strpos($html, '<footer>'));
    }

    public function test_rodape_tem_cada_coluna_uma_vez_so()
    {
        $rodape = $this->rodape();

        $this->assertSame(1, substr_count($rodape, '<h2>Institucional</h2>'));
        $this->assertSame(1, substr_count($rodape, '<h2>Soluções</h2>'));
        $this->assertSame(1, substr_count($rodape, '<h2>Transparência</h2>'));
    }

    public function test_coluna_institucional_leva_para_as_paginas()
    {
        $rodape = $this->rodape();

        $this->assertStringContainsString('<a href="' . route('institucional') . '">Quem somos</a>', $rodape);
        $this->assertStringContainsString('<a href="' . route('institucional') . '#linha-do-tempo">Linha do tempo</a>', $rodape);
        $this->assertStringContainsString('<a href="' . route('institucional') . '#governanca">Governança</a>', $rodape);
        $this->assertStringContainsString('<a href="' . route('marco-legal') . '">Marco Legal</a>', $rodape);
    }

    public function test_coluna_solucoes_leva_para_as_paginas_certas()
    {
        $rodape = $this->rodape();

        $this->assertStringContainsString('<a href="' . route('projetos') . '">Projetos e produtos</a>', $rodape);
        $this->assertStringContainsString('<a href="' . route('editais') . '">Editais e chamamentos</a>', $rodape);
        $this->assertStringNotContainsString('<a href="' . route('atuacao') . '">Projetos e produtos</a>', $rodape);
        $this->assertStringNotContainsString('<a href="' . route('transparencia') . '">Editais e chamamentos</a>', $rodape);
    }
}
