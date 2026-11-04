<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Revisão das páginas Projetos e Editais no celular.
 *
 * Trava o que foi conferido abrindo as duas páginas no navegador com 360px e
 * 390px de largura: nada escapa para os lados, os blocos empilham, os textos
 * continuam legíveis e os alvos de toque têm pelo menos 44px.
 */
class MobileProjetosEditaisTest extends TestCase
{
    use RefreshDatabase;

    private const PAGINAS = ['/projetos', '/editais'];

    private function css(): string
    {
        return (string) file_get_contents(public_path('css/style.css'));
    }

    /**
     * Junta o conteúdo de todos os blocos @media cujo cabeçalho casa com a
     * consulta (os espaços são ignorados), para conferir as regras de celular.
     */
    private function regrasDe(string $consulta): string
    {
        $css = $this->css();
        $procurado = str_replace(' ', '', $consulta);
        $tamanho = strlen($css);
        $saida = '';
        $posicao = 0;

        while (($inicio = strpos($css, '@media', $posicao)) !== false) {
            $abre = strpos($css, '{', $inicio);

            if ($abre === false) {
                break;
            }

            $cabecalho = str_replace(' ', '', substr($css, $inicio, $abre - $inicio));

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

            if (str_contains($cabecalho, $procurado)) {
                $saida .= substr($css, $abre + 1, $i - $abre - 2);
            }

            $posicao = $i;
        }

        return str_replace(' ', '', $saida);
    }

    public function test_as_duas_paginas_declaram_a_largura_do_aparelho()
    {
        foreach (self::PAGINAS as $pagina) {
            $this->get($pagina)
                ->assertOk()
                ->assertSee('name="viewport" content="width=device-width, initial-scale=1"', false);
        }
    }

    public function test_ilustracao_do_topo_acompanha_a_largura_da_tela()
    {
        foreach (self::PAGINAS as $pagina) {
            $html = $this->get($pagina)->assertOk()->getContent();

            preg_match('/<svg[^>]*>/', $html, $svg);

            $this->assertNotEmpty($svg, "$pagina: não achou a ilustração do topo");
            $this->assertStringContainsString('viewBox', $svg[0], "$pagina: o SVG precisa de viewBox para escalar");
            $this->assertDoesNotMatchRegularExpression(
                '/\swidth="\d/',
                $svg[0],
                "$pagina: o SVG não pode ter largura fixa em pixels"
            );
        }
    }

    public function test_nenhum_bloco_das_paginas_tem_largura_fixa_em_pixels()
    {
        foreach (self::PAGINAS as $pagina) {
            $html = $this->get($pagina)->assertOk()->getContent();

            $this->assertDoesNotMatchRegularExpression(
                '/style="[^"]*\bwidth:\s*\d{3,}px/i',
                $html,
                "$pagina: largura fixa no HTML estoura a tela do celular"
            );
        }
    }

    public function test_cartoes_e_numeros_empilham_no_celular()
    {
        $celular = $this->regrasDe('(max-width:600px)');

        $this->assertStringContainsString('.cards-grid{grid-template-columns:1fr;}', $celular);
        $this->assertStringContainsString('.norma-grid{grid-template-columns:1fr;}', $this->regrasDe('(max-width:900px)'));
        $this->assertStringContainsString('.stats-grid{grid-template-columns:1fr1fr;}', $celular);
    }

    public function test_carrossel_de_etapas_mostra_um_cartao_por_vez_no_celular()
    {
        $this->assertStringContainsString('--per-view:1;', $this->regrasDe('(max-width:600px)'));
    }

    public function test_datas_do_edital_ficam_lado_a_lado_no_celular()
    {
        // Em uma coluna só, cada cartão de edital esticava quase uma tela
        // inteira para mostrar duas datas.
        $this->assertMatchesRegularExpression(
            '/\.card\.ficha\{[^}]*grid-template-columns:repeat\(2,minmax\(0,1fr\)\)/',
            $this->regrasDe('(max-width:600px)')
        );
    }

    public function test_alvos_de_toque_do_celular_tem_pelo_menos_44px()
    {
        $css = str_replace(' ', '', $this->css());

        // Botão que abre o menu no celular.
        $this->assertMatchesRegularExpression('/\.menu-toggle\{[^}]*min-height:44px/', $css);
        $this->assertMatchesRegularExpression('/\.menu-toggle\{[^}]*min-width:44px/', $css);

        // Setas do carrossel de etapas da página Editais.
        $celular = $this->regrasDe('(max-width:600px)');
        $this->assertMatchesRegularExpression('/\.steps-nav\{[^}]*width:44px;height:44px/', $celular);
    }

    public function test_link_dos_cartoes_de_projeto_se_parece_com_link()
    {
        $css = str_replace(' ', '', $this->css());

        $this->assertMatchesRegularExpression(
            '/\.carda\.link\{[^}]*color:var\(--navy\)/',
            $css,
            'O "Conhecer a solução" dos cartões precisa de cor própria'
        );
        $this->assertMatchesRegularExpression(
            '/\.carda\.link\{[^}]*border-bottom:1pxsolid/',
            $css,
            'O link dos cartões precisa de sublinhado para ser reconhecido'
        );
    }
}
