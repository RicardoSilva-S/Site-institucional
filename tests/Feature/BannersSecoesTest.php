<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\User;
use App\Support\BannerSlots;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BannersSecoesTest extends TestCase
{
    use RefreshDatabase;

    /** Seções que tinham espaço vazio ao lado do título: rota => [posição => url]. */
    private const POSICOES = [
        'home' => ['steps' => '/', 'cards' => '/', 'stats' => '/'],
        'projetos' => ['impacto' => '/projetos', 'portfolio' => '/projetos'],
        'editais' => ['etapas' => '/editais', 'parceria' => '/editais', 'avisos' => '/editais', 'lista' => '/editais'],
        'marco-legal' => ['hero' => '/marco-legal', 'normas' => '/marco-legal', 'mapa' => '/marco-legal', 'procuradorias' => '/marco-legal'],
        'contato' => ['hero' => '/contato'],
        'transparencia' => ['hero' => '/transparencia'],
    ];

    public function test_secoes_mostram_a_imagem_padrao_sem_banner_cadastrado()
    {
        foreach (self::POSICOES as $rota => $posicoes) {
            foreach ($posicoes as $slot => $url) {
                $padrao = BannerSlots::fallback($rota, $slot);

                $this->assertNotNull($padrao, "$rota:$slot sem imagem padrão no config");
                $this->assertFileExists(public_path($padrao));
                $this->get($url)->assertOk()->assertSee($padrao);
            }
        }
    }

    public function test_posicoes_aparecem_no_formulario_de_banner_do_painel()
    {
        $html = $this->actingAs(User::factory()->create())
            ->get('/adm/banners/create')
            ->assertOk()
            ->getContent();

        foreach (self::POSICOES as $rota => $posicoes) {
            foreach (array_keys($posicoes) as $slot) {
                $this->assertStringContainsString('value="'.BannerSlots::encode($rota, $slot).'"', $html);
            }
        }
    }

    public function test_banner_cadastrado_substitui_a_imagem_padrao_so_da_sua_secao()
    {
        Banner::create([
            'page' => 'marco-legal',
            'slot' => 'normas',
            'image' => 'uploads/banners/normas.jpg',
            'display_title' => 'Biblioteca jurídica',
            'active' => true,
        ]);

        $this->get('/marco-legal')
            ->assertSee('uploads/banners/normas.jpg')
            ->assertSee('Biblioteca jurídica')
            ->assertDontSee('assets/marco-legal/normas.svg')
            ->assertSee('assets/marco-legal/mapa.svg');
    }
}
