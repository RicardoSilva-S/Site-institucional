<?php

namespace Tests\Feature;

use App\Models\Edital;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EditaisCadastroTest extends TestCase
{
    use RefreshDatabase;

    private const PAGINA = '/editais';
    private const PAINEL = '/adm/editais';
    private const EDITAL_004 = 'Chamamento Público nº 004/2026 – Soluções de Transparência e Participação Legislativa para Câmaras Municipais';
    private const NOVO = 'Chamamento Público nº 005/2026 – Teste';

    private function editor(): User
    {
        return User::factory()->create(['papel' => User::PAPEL_EDITOR]);
    }

    private function pdf(string $nome = 'edital.pdf'): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($nome, "%PDF-1.4\nedital de teste\n%%EOF");
    }

    private function dados(array $extra = []): array
    {
        return array_merge([
            'titulo' => self::NOVO,
            'resumo' => 'Resumo do edital de teste.',
            'status' => 'aberto',
            'abertura' => '2026-10-10',
            'encerramento' => '2026-12-10',
        ], $extra);
    }

    public function test_pagina_mostra_os_editais_iniciais_vindos_do_banco(): void
    {
        $this->assertSame(4, Edital::count());

        $this->get(self::PAGINA)
            ->assertOk()
            ->assertSee(self::EDITAL_004)
            ->assertSee('05/10/2026')
            ->assertSee('Em análise')
            ->assertSee('Encerrado');
    }

    public function test_editais_aparecem_do_mais_recente_para_o_mais_antigo(): void
    {
        $this->get(self::PAGINA)->assertSeeInOrder([
            'nº 004/2026', 'nº 003/2026', 'nº 002/2026', 'nº 001/2026',
        ]);
    }

    public function test_quadro_de_avisos_conta_pela_situacao(): void
    {
        $this->get(self::PAGINA)->assertViewHas('contagem', function ($contagem) {
            return $contagem->get('aberto') === 2
                && $contagem->get('analise') === 1
                && $contagem->get('encerrado') === 1;
        });
    }

    public function test_edital_sem_pdf_nao_mostra_botao_quebrado(): void
    {
        $this->get(self::PAGINA)
            ->assertDontSee('Baixar edital')
            ->assertDontSee('href="#"', false);
    }

    public function test_sem_login_nao_acessa_o_painel(): void
    {
        $this->get(self::PAINEL)->assertRedirect(route('login'));
    }

    public function test_painel_lista_os_editais(): void
    {
        $this->actingAs($this->editor())->get(self::PAINEL)
            ->assertOk()
            ->assertSee('nº 004/2026')
            ->assertSee('sem PDF');
    }

    public function test_cadastra_edital_com_pdf_e_o_site_mostra_o_botao(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados(['arquivo' => $this->pdf('edital-005.pdf')]))
            ->assertRedirect(self::PAINEL)
            ->assertSessionHasNoErrors();

        $edital = Edital::where('titulo', self::NOVO)->firstOrFail();
        $this->assertSame('edital-005.pdf', $edital->arquivo_nome);

        $this->get(self::PAGINA)
            ->assertSee(self::NOVO)
            ->assertSee('Baixar edital')
            ->assertSee(route('editais.pdf', $edital), false);
    }

    public function test_download_entrega_o_pdf_guardado_no_banco(): void
    {
        $edital = Edital::create($this->dados([
            'arquivo_nome' => 'edital.pdf',
            'arquivo_data' => base64_encode('%PDF-1.4 conteudo'),
        ]));

        $resposta = $this->get(route('editais.pdf', $edital))->assertOk();

        $this->assertSame('application/pdf', $resposta->headers->get('Content-Type'));
        $this->assertSame('%PDF-1.4 conteudo', $resposta->getContent());
    }

    public function test_edital_encerrado_com_pdf_mostra_acessar_resultado(): void
    {
        Edital::create($this->dados([
            'status' => 'encerrado',
            'arquivo_nome' => 'resultado.pdf',
            'arquivo_data' => base64_encode('%PDF'),
        ]));

        $this->get(self::PAGINA)->assertSee('Acessar resultado');
    }

    public function test_download_de_edital_sem_pdf_da_404(): void
    {
        $this->get(route('editais.pdf', Edital::first()))->assertNotFound();
    }

    public function test_recusa_arquivo_que_nao_e_pdf(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados(['arquivo' => UploadedFile::fake()->create('planilha.xlsx', 10)]))
            ->assertSessionHasErrors('arquivo');

        $this->assertDatabaseMissing('editais', ['titulo' => self::NOVO]);
    }

    public function test_titulo_obrigatorio_e_encerramento_nao_pode_ser_antes_da_abertura(): void
    {
        $this->actingAs($this->editor())
            ->post(self::PAINEL, $this->dados(['titulo' => '', 'abertura' => '2026-10-10', 'encerramento' => '2026-10-01']))
            ->assertSessionHasErrors(['titulo', 'encerramento']);
    }

    public function test_mudar_a_situacao_atualiza_o_quadro_de_avisos(): void
    {
        $edital = Edital::where('status', 'analise')->firstOrFail();

        $this->actingAs($this->editor())
            ->put(self::PAINEL . "/{$edital->id}", $this->dados([
                'titulo' => $edital->titulo,
                'status' => 'encerrado',
                'abertura' => '2026-07-15',
                'encerramento' => '2026-09-14',
            ]))
            ->assertRedirect(self::PAINEL);

        $this->get(self::PAGINA)->assertViewHas('contagem', function ($contagem) {
            return $contagem->get('analise') === null && $contagem->get('encerrado') === 2;
        });
    }

    public function test_remove_o_pdf_e_o_botao_some(): void
    {
        $edital = Edital::create($this->dados([
            'arquivo_nome' => 'edital.pdf',
            'arquivo_data' => base64_encode('%PDF'),
        ]));

        $this->actingAs($this->editor())
            ->put(self::PAINEL . "/{$edital->id}", $this->dados(['remover_arquivo' => '1']));

        $this->assertFalse($edital->fresh()->temArquivo());
        $this->get(self::PAGINA)->assertDontSee('Baixar edital');
    }

    public function test_excluir_edital_tira_da_pagina(): void
    {
        $edital = Edital::where('titulo', self::EDITAL_004)->firstOrFail();

        $this->actingAs($this->editor())
            ->delete(self::PAINEL . "/{$edital->id}")
            ->assertRedirect(self::PAINEL);

        $this->get(self::PAGINA)->assertDontSee('nº 004/2026');
    }
}
