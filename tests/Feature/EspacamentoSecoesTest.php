<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Régua de espaçamento do site.
 *
 * O espaço entre seções sai de duas variáveis, uma para tela grande e outra
 * para celular. Quem quiser afinar o visual mexe nelas, não em cada seção.
 */
class EspacamentoSecoesTest extends TestCase
{
    private function css(): string
    {
        return str_replace(' ', '', (string) file_get_contents(public_path('css/style.css')));
    }

    public function test_regua_de_espacamento_fica_em_variaveis()
    {
        $css = $this->css();

        $this->assertMatchesRegularExpression('/--space-section:\d+px;/', $css);
        $this->assertMatchesRegularExpression('/--space-section-sm:\d+px;/', $css);
    }

    public function test_secoes_usam_a_regua_em_vez_de_valor_cravado()
    {
        $css = $this->css();

        $this->assertStringContainsString('section{padding:var(--space-section)0;}', $css);
        $this->assertStringContainsString('section{padding:var(--space-section-sm)0;}', $css);
    }

    public function test_celular_ganha_margem_lateral_mais_justa()
    {
        // 24px de cada lado tiravam 48px dos 360px de uma tela comum.
        $css = $this->css();

        $this->assertMatchesRegularExpression(
            '/\.wrap,\s*\.extra-texts\{padding-left:16px;padding-right:16px;\}/',
            $css
        );
    }
}
