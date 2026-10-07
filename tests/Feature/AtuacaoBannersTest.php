<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AtuacaoBannersTest extends TestCase
{
    use RefreshDatabase;

    /** @var string[] arquivos que já existiam em public/uploads/banners */
    private $uploadsAntes = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->uploadsAntes = $this->uploads();
    }

    protected function tearDown(): void
    {
        // Apaga as imagens enviadas pelos testes.
        File::delete(array_diff($this->uploads(), $this->uploadsAntes));

        parent::tearDown();
    }

    private function uploads(): array
    {
        return array_map(fn ($file) => $file->getPathname(), File::files(public_path('uploads/banners')));
    }

    private function imagem(): UploadedFile
    {
        // PNG de 1x1 px (o PHP do projeto não tem GD para gerar imagens fake).
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');

        return UploadedFile::fake()->createWithContent('banner.png', $png);
    }

    public function test_frentes_mostram_a_imagem_padrao_sem_banner_cadastrado()
    {
        $this->get('/atuacao')
            ->assertOk()
            ->assertSee('assets/atuacao/hero.svg')
            ->assertSee('assets/atuacao/governanca.svg')
            ->assertSee('assets/atuacao/piloto.svg');
    }

    public function test_banner_enviado_no_painel_substitui_a_imagem_padrao_da_secao()
    {
        $this->actingAs(User::factory()->create())
            ->post('/adm/banners', [
                'posicao' => 'atuacao:governanca',
                'image' => $this->imagem(),
                'title' => 'Oficina de processos',
                'active' => '1',
            ])
            ->assertRedirect(route('admin.banners.index'));

        $banner = Banner::query()->firstOrFail();
        $this->assertSame('atuacao', $banner->page);
        $this->assertSame('governanca', $banner->slot);

        $this->get('/atuacao')
            ->assertSee($banner->imageUrl(), false)
            ->assertSee('Oficina de processos')
            ->assertDontSee('assets/atuacao/governanca.svg')
            ->assertSee('assets/atuacao/pmo.svg');
    }

    public function test_banner_de_secao_nao_aparece_no_carrossel_do_topo()
    {
        Banner::create(['page' => 'atuacao', 'slot' => 'pmo', 'image' => 'uploads/banners/pmo.jpg', 'active' => true]);

        $this->get('/atuacao')
            ->assertSee('uploads/banners/pmo.jpg')
            ->assertDontSee('banner-slider');
    }

    public function test_banner_inativo_volta_a_mostrar_a_imagem_padrao()
    {
        Banner::create(['page' => 'atuacao', 'slot' => 'pmo', 'image' => 'uploads/banners/pmo.jpg', 'active' => false]);

        $this->get('/atuacao')
            ->assertDontSee('uploads/banners/pmo.jpg')
            ->assertSee('assets/atuacao/pmo.svg');
    }

    public function test_posicao_inexistente_e_recusada()
    {
        $this->actingAs(User::factory()->create())
            ->post('/adm/banners', [
                'posicao' => 'atuacao:nao-existe',
                'image' => $this->imagem(),
            ])
            ->assertSessionHasErrors('posicao');

        $this->assertSame(0, Banner::query()->count());
    }

    public function test_editor_da_pagina_troca_a_imagem_da_secao_e_volta_para_ela()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get('/adm/paginas/atuacao')
            ->assertOk()
            ->assertSee('Imagem da seção')
            ->assertSee('assets/atuacao/capacitacao.svg');

        $form = $this->actingAs($admin)
            ->get('/adm/banners/create?posicao=atuacao:capacitacao&voltar=atuacao')
            ->assertOk()
            ->assertSee('name="voltar" value="atuacao"', false)
            ->getContent();
        $this->assertMatchesRegularExpression('/value="atuacao:capacitacao"[^>]*selected/', $form);

        $this->actingAs($admin)
            ->post('/adm/banners', [
                'posicao' => 'atuacao:capacitacao',
                'image' => $this->imagem(),
                'active' => '1',
                'voltar' => 'atuacao',
            ])
            ->assertRedirect(route('admin.pages.show', 'atuacao').'#secao-capacitacao');

        $banner = Banner::query()->firstOrFail();

        $this->actingAs($admin)
            ->get('/adm/paginas/atuacao')
            ->assertSee($banner->imageUrl(), false);

        $this->actingAs($admin)
            ->delete('/adm/banners/'.$banner->id, ['voltar' => 'atuacao'])
            ->assertRedirect(route('admin.pages.show', 'atuacao').'#secao-capacitacao');

        $this->assertSame(0, Banner::query()->count());
    }
}
