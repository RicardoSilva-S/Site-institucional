<?php

namespace Tests\Feature;

use App\Models\MarcoInstitucional;
use App\Models\SiteText;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarcosInstitucionaisTest extends TestCase
{
    use RefreshDatabase;

    private const PAINEL = '/adm/marcos';
    private const NOVO = 'Primeiro convênio com município';

    private function editor(): User
    {
        return User::factory()->create(['papel' => User::PAPEL_EDITOR]);
    }

    public function test_os_cinco_passos_antigos_viraram_marcos(): void
    {
        $this->assertSame(
            ['Jul · 2025', 'Set · 2025', 'Jan · 2026', '2026', 'Ago · 2026'],
            MarcoInstitucional::naOrdem()->pluck('data')->all()
        );

        $this->assertDatabaseMissing('site_texts', ['key' => 'institucional.passo1.title']);
    }

    public function test_institucional_mostra_os_marcos_na_ordem(): void
    {
        $this->get(route('institucional'))
            ->assertOk()
            ->assertSeeInOrder(['Jul · 2025', 'Set · 2025', 'Ago · 2026']);
    }

    public function test_sem_login_nao_acessa_o_painel(): void
    {
        $this->get(self::PAINEL)->assertRedirect(route('login'));
    }

    public function test_painel_lista_os_marcos(): void
    {
        $this->actingAs($this->editor())->get(self::PAINEL)
            ->assertOk()
            ->assertSee('Marcos da linha do tempo')
            ->assertSee('Jan · 2026');
    }

    public function test_adiciona_marco_e_ele_aparece_no_site(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, ['data' => 'Nov · 2026', 'texto' => self::NOVO, 'ordem' => 6])
            ->assertRedirect(self::PAINEL)
            ->assertSessionHasNoErrors();

        $this->get(route('institucional'))
            ->assertSee('Nov · 2026')
            ->assertSee(self::NOVO);
    }

    public function test_data_e_texto_sao_obrigatorios(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, ['ordem' => 1])
            ->assertSessionHasErrors(['data', 'texto']);
    }

    public function test_edita_marco(): void
    {
        $marco = MarcoInstitucional::where('data', '2026')->firstOrFail();

        $this->actingAs($this->editor())
            ->put(self::PAINEL . "/{$marco->id}", ['data' => 'Mar · 2026', 'texto' => $marco->texto, 'ordem' => $marco->ordem])
            ->assertRedirect(self::PAINEL);

        $this->assertSame('Mar · 2026', $marco->fresh()->data);
    }

    public function test_remover_marco_tira_do_site(): void
    {
        $marco = MarcoInstitucional::where('data', 'Jan · 2026')->firstOrFail();

        $this->actingAs($this->editor())
            ->delete(self::PAINEL . "/{$marco->id}")
            ->assertRedirect(self::PAINEL);

        $this->get(route('institucional'))->assertDontSee('Jan · 2026');
    }

    public function test_passos_nao_aparecem_mais_no_editor_de_textos(): void
    {
        $this->actingAs($this->editor())->get('/adm/paginas/institucional')
            ->assertOk()
            ->assertDontSee('Passo 1 — data');

        $this->assertSame(0, SiteText::where('key', 'like', 'institucional.passo%')->count());
    }
}