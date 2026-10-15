<?php

namespace Tests\Feature;

use App\Models\Projeto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjetosCadastroTest extends TestCase
{
    use RefreshDatabase;

    private const PAGINA = '/projetos';
    private const PAINEL = '/adm/projetos';
    private const TOTEM = 'Totem de Autoatendimento';
    private const MOBILIDADE = 'Mobilidade e Frota Pública';
    private const NOVO = 'Iluminação Pública Inteligente';

    private function editor(): User
    {
        return User::factory()->create(['papel' => User::PAPEL_EDITOR]);
    }

    private function dados(array $extra = []): array
    {
        return array_merge([
            'titulo' => self::NOVO,
            'categorias' => 'Cidades inteligentes',
            'estagio' => 'piloto',
            'breve_descricao' => 'Controla a iluminação das ruas com sensores.',
            'tecnologia' => 'sensores e painel de controle.',
            'link_rotulo' => 'Conhecer o projeto',
            'link_destino' => 'contato',
            'ordem' => 6,
        ], $extra);
    }

    public function test_pagina_mostra_os_projetos_iniciais_vindos_do_banco(): void
    {
        $this->assertSame(5, Projeto::count());

        $this->get(self::PAGINA)->assertOk()->assertSeeInOrder([
            self::TOTEM, 'Alô Câmara', 'Lei Municipal de Inovação', 'Gestão de Manutenção Municipal', self::MOBILIDADE,
        ]);
    }

    public function test_cartao_mostra_situacao_frente_tecnologia_e_link(): void
    {
        $this->get(self::PAGINA)
            ->assertSee('<span class="status publicado">Implementado</span>', false)
            ->assertSee('<span class="status elaboracao">Fase piloto</span>', false)
            ->assertSee('Atendimento ao cidadão')
            ->assertSee('autoatendimento digital, interface acessível')
            ->assertSee('<a href="' . route('marco-legal') . '" class="link">Conhecer o marco legal</a>', false);
    }

    public function test_sem_login_nao_acessa_o_painel(): void
    {
        $this->get(self::PAINEL)->assertRedirect(route('login'));
    }

    public function test_painel_lista_os_projetos(): void
    {
        $this->actingAs($this->editor())->get(self::PAINEL)
            ->assertOk()
            ->assertSee(self::TOTEM)
            ->assertSee('Em expansão');
    }

    public function test_cadastra_projeto_e_ele_aparece_no_site(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados())
            ->assertRedirect(self::PAINEL)
            ->assertSessionHasNoErrors();

        $this->get(self::PAGINA)
            ->assertSee(self::NOVO)
            ->assertSee('Cidades inteligentes')
            ->assertSeeInOrder([self::MOBILIDADE, self::NOVO]);
    }

    public function test_nome_e_descricao_sao_obrigatorios_e_situacao_precisa_existir(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados(['titulo' => '', 'breve_descricao' => '', 'estagio' => 'inventado']))
            ->assertSessionHasErrors(['titulo', 'breve_descricao', 'estagio']);
    }

    public function test_link_so_pode_levar_para_paginas_do_site(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados(['link_destino' => 'https://site-externo.com']))
            ->assertSessionHasErrors('link_destino');
    }

    public function test_projeto_sem_texto_de_link_aparece_sem_link(): void
    {
        $this->actingAs($this->editor())->post(self::PAINEL, $this->dados(['link_rotulo' => '']));

        $html = $this->get(self::PAGINA)->getContent();
        $cartao = substr($html, strpos($html, self::NOVO), 600);

        $this->assertStringNotContainsString('class="link"', explode('</article>', $cartao)[0]);
    }

    public function test_edita_situacao_e_ordem(): void
    {
        $mobilidade = Projeto::where('titulo', self::MOBILIDADE)->firstOrFail();

        $this->actingAs($this->editor())
            ->put(self::PAINEL . "/{$mobilidade->id}", $this->dados([
                'titulo' => self::MOBILIDADE,
                'estagio' => 'implementado',
                'ordem' => 0,
            ]))
            ->assertRedirect(self::PAINEL);

        $this->get(self::PAGINA)->assertSeeInOrder([self::MOBILIDADE, self::TOTEM]);
        $this->assertSame('implementado', $mobilidade->fresh()->estagio);
    }

    public function test_excluir_projeto_tira_da_pagina(): void
    {
        $totem = Projeto::where('titulo', self::TOTEM)->firstOrFail();

        $this->actingAs($this->editor())
            ->delete(self::PAINEL . "/{$totem->id}")
            ->assertRedirect(self::PAINEL);

        $this->get(self::PAGINA)->assertDontSee(self::TOTEM);
    }
}
