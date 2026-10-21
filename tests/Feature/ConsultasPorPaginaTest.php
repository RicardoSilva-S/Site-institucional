<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ConsultasPorPaginaTest extends TestCase
{
    use RefreshDatabase;

    private function consultasAoAbrir(string $pagina): array
    {
        $this->get($pagina); // primeira visita aquece o cache dos textos

        $consultas = [];
        DB::listen(function ($evento) use (&$consultas) {
            $consultas[] = $evento->sql;
        });

        $this->get($pagina)->assertOk();

        return $consultas;
    }

    public function test_paginas_nao_checam_se_tabela_existe()
    {
        foreach (['/', '/atuacao', '/contato', '/transparencia'] as $pagina) {
            $checagens = array_filter($this->consultasAoAbrir($pagina), function ($sql) {
                return strpos($sql, 'sqlite_master') !== false || strpos($sql, 'information_schema') !== false;
            });

            $this->assertCount(0, $checagens, "$pagina ainda checa se tabela existe");
        }
    }

    public function test_contato_abre_com_no_maximo_duas_consultas()
    {
        $this->assertLessThanOrEqual(2, count($this->consultasAoAbrir('/contato')));
    }
}
