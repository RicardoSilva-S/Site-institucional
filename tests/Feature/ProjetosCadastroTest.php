<?php

namespace Tests\Feature;

use App\Models\DescricaoProjeto;
use App\Models\Projeto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Página /projetos (catálogo do modelo antigo), página de detalhe
 * /projetos/{slug} e cadastro dos cartões no painel (/adm/projetos).
 */
class ProjetosCadastroTest extends TestCase
{
    use RefreshDatabase;

    private const PAGINA = '/projetos';
    private const PAINEL = '/adm/projetos';
    private const ACQUORA = 'Acquora';
    private const CAPACITACAO = 'Capacitação de Servidores';
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
            'icone' => 'padrao',
            'estagio' => 'piloto',
            'breve_descricao' => 'Controla a iluminação das ruas com sensores.',
            'tecnologia' => 'sensores e painel de controle.',
            'link_rotulo' => 'Conhecer o projeto',
            'link_destino' => 'contato',
            'ordem' => 7,
        ], $extra);
    }

    public function test_pagina_mostra_o_catalogo_vindo_do_banco(): void
    {
        $this->assertSame(6, Projeto::count());

        $this->get(self::PAGINA)->assertOk()->assertSeeInOrder([
            self::ACQUORA, 'Compaxis Connect', 'ConciliadorNF', 'Alô Câmara',
            'Estrutura Municipal de Inovação', self::CAPACITACAO,
        ]);
    }

    public function test_pagina_tem_as_secoes_do_modelo_antigo(): void
    {
        $this->get(self::PAGINA)->assertOk()->assertSeeInOrder([
            'Projetos e produtos',
            'Soluções desenvolvidas e reunidas pelo Instituto',
            'Clique em cada solução para ver a descrição completa.',
            'Nenhuma solução é oferecida sem caminho jurídico',
            'Ver os instrumentos disponíveis',
            'Solicitar reunião técnica',
            'Desenvolve uma solução para o setor público?',
            'Como se tornar parceiro',
        ]);
    }

    public function test_cartao_mostra_categoria_selo_e_link_de_detalhe(): void
    {
        $this->get(self::PAGINA)
            ->assertSee('Saneamento')
            ->assertSee('<span class="status publicado">Disponível</span>', false)
            ->assertSee('<span class="status elaboracao">Em desenvolvimento</span>', false)
            ->assertSee('href="' . route('projetos.show', 'acquora') . '"', false)
            ->assertSee('Ver detalhes<span class="visually-hidden"> de Acquora</span>', false);
    }

    public function test_pagina_de_detalhe_mostra_o_projeto(): void
    {
        $acquora = Projeto::where('slug', 'acquora')->firstOrFail();
        DescricaoProjeto::create(['projeto_id' => $acquora->id, 'titulo' => 'O que o Acquora faz', 'texto' => 'Organiza as ordens de serviço.']);

        $this->get('/projetos/acquora')
            ->assertOk()
            ->assertSee('<h1>Acquora</h1>', false)
            ->assertSee('Disponível')
            ->assertSeeInOrder(['O que o Acquora faz', 'Organiza as ordens de serviço.'])
            ->assertSee('Solicitar reunião técnica');
    }

    public function test_detalhe_de_projeto_inexistente_da_404(): void
    {
        $this->get('/projetos/nao-existe')->assertNotFound();
    }

    public function test_sem_login_nao_acessa_o_painel(): void
    {
        $this->get(self::PAINEL)->assertRedirect(route('login'));
    }

    public function test_painel_lista_os_projetos(): void
    {
        $this->actingAs($this->editor())->get(self::PAINEL)
            ->assertOk()
            ->assertSee(self::ACQUORA)
            ->assertSee('Em desenvolvimento');
    }

    public function test_cadastra_projeto_e_ele_aparece_no_site_com_endereco_gerado(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados())
            ->assertRedirect(self::PAINEL)
            ->assertSessionHasNoErrors();

        $this->assertSame('iluminacao-publica-inteligente', Projeto::where('titulo', self::NOVO)->value('slug'));

        $this->get(self::PAGINA)
            ->assertSee(self::NOVO)
            ->assertSee('Cidades inteligentes')
            ->assertSeeInOrder([self::CAPACITACAO, self::NOVO]);

        $this->get('/projetos/iluminacao-publica-inteligente')->assertOk()->assertSee(self::NOVO);
    }

    public function test_endereco_repetido_ganha_numero(): void
    {
        $this->actingAs($this->editor())->post(self::PAINEL, $this->dados(['titulo' => self::ACQUORA]));

        $this->assertSame(['acquora', 'acquora-2'], Projeto::where('titulo', self::ACQUORA)->orderBy('id')->pluck('slug')->all());
    }

    public function test_endereco_informado_precisa_ser_unico(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados(['slug' => 'acquora']))
            ->assertSessionHasErrors('slug');
    }

    public function test_nome_e_descricao_sao_obrigatorios_e_situacao_e_icone_precisam_existir(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados(['titulo' => '', 'breve_descricao' => '', 'estagio' => 'inventado', 'icone' => 'inventado']))
            ->assertSessionHasErrors(['titulo', 'breve_descricao', 'estagio', 'icone']);
    }

    public function test_link_so_pode_levar_para_paginas_do_site(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados(['link_destino' => 'https://site-externo.com']))
            ->assertSessionHasErrors('link_destino');
    }

    public function test_edita_situacao_e_ordem(): void
    {
        $capacitacao = Projeto::where('titulo', self::CAPACITACAO)->firstOrFail();

        $this->actingAs($this->editor())
            ->put(self::PAINEL . "/{$capacitacao->id}", $this->dados([
                'titulo' => self::CAPACITACAO,
                'slug' => $capacitacao->slug,
                'estagio' => 'desenvolvimento',
                'ordem' => 0,
            ]))
            ->assertRedirect(self::PAINEL)
            ->assertSessionHasNoErrors();

        $this->get(self::PAGINA)->assertSeeInOrder([self::CAPACITACAO, self::ACQUORA]);
        $this->assertSame('desenvolvimento', $capacitacao->fresh()->estagio);
        $this->assertSame('capacitacao-de-servidores', $capacitacao->fresh()->slug);
    }

    public function test_excluir_projeto_tira_da_pagina(): void
    {
        $acquora = Projeto::where('titulo', self::ACQUORA)->firstOrFail();

        $this->actingAs($this->editor())
            ->delete(self::PAINEL . "/{$acquora->id}")
            ->assertRedirect(self::PAINEL);

        $this->get(self::PAGINA)->assertDontSee(self::ACQUORA);
        $this->get('/projetos/acquora')->assertNotFound();
    }
}
