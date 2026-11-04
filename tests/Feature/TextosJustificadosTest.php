<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Textos de leitura justificados.
 *
 * A regra fica fora de qualquer @media de propósito: vale também no celular.
 */
class TextosJustificadosTest extends TestCase
{
    use RefreshDatabase;

    /** Blocos de leitura que precisam sair justificados. */
    private const BLOCOS = [
        '.hero.lead',
        '.page-hero.lead',
        '.section-head.sub',
        '.card p',
        '.step p',
        '.timeline p',
        '.transp-item p',
        '.frente-itens p',
        '.info-box p',
        '.qa-block.answer',
        '.cta-panel p',
        '.contact-card p',
        '.link-card__text',
        '.banner-slide__content p',
        '.final-cta p',
        '.extra-texts p',
    ];

    /** O CSS sem o conteúdo dos blocos @media. */
    private function cssSemMedia(): string
    {
        $css = (string) file_get_contents(public_path('css/style.css'));
        $tamanho = strlen($css);
        $saida = '';
        $posicao = 0;

        while (($inicio = strpos($css, '@media', $posicao)) !== false) {
            $abre = strpos($css, '{', $inicio);

            if ($abre === false) {
                break;
            }

            $saida .= substr($css, $posicao, $inicio - $posicao);

            // Anda até a chave que fecha este @media, contando os blocos internos.
            $nivel = 1;
            $i = $abre + 1;

            while ($i < $tamanho && $nivel > 0) {
                if ($css[$i] === '{') {
                    $nivel++;
                } elseif ($css[$i] === '}') {
                    $nivel--;
                }
                $i++;
            }

            $posicao = $i;
        }

        return str_replace(' ', '', $saida . substr($css, $posicao));
    }

    public function test_regra_vale_em_qualquer_largura_inclusive_no_celular()
    {
        $this->assertStringContainsString(
            'text-align:justify;',
            $this->cssSemMedia(),
            'O justificado não pode ficar preso dentro de um @media'
        );
    }

    public function test_blocos_de_leitura_estao_na_regra()
    {
        $css = $this->cssSemMedia();

        foreach (self::BLOCOS as $bloco) {
            $this->assertStringContainsString(
                str_replace(' ', '', $bloco) . ',',
                $css,
                "$bloco ficou de fora do texto justificado"
            );
        }
    }

    public function test_justificado_vem_com_hifenizacao()
    {
        // Sem hifenizar, a coluna estreita do celular abre buracos entre as
        // palavras. A hifenização usa o lang="pt-BR" do <html>.
        $css = $this->cssSemMedia();

        $this->assertStringContainsString('hyphens:auto;', $css);
        $this->assertStringContainsString('-webkit-hyphens:auto;', $css);
        $this->assertStringContainsString('hyphenate-limit-chars:633;', $css);
    }

    public function test_paginas_declaram_o_idioma_que_a_hifenizacao_usa()
    {
        foreach (['/', '/projetos', '/editais', '/institucional'] as $pagina) {
            $this->get($pagina)->assertOk()->assertSee('<html lang="pt-BR">', false);
        }
    }
}
