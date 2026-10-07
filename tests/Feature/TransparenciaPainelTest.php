<?php

namespace Tests\Feature;

use App\Models\TransparenciaDocumento;
use App\Models\TransparenciaSecao;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TransparenciaPainelTest extends TestCase
{
    use RefreshDatabase;

    private const PAINEL = '/adm/transparencia';
    private const SECOES = self::PAINEL . '/secoes';
    private const DOCUMENTOS = self::PAINEL . '/documentos';

    private function editor(): User
    {
        return User::factory()->create(['papel' => User::PAPEL_EDITOR]);
    }

    private function pdf(string $nome = 'estatuto.pdf'): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($nome, "%PDF-1.4\nconteudo de teste\n%%EOF");
    }

    private function secao(): TransparenciaSecao
    {
        return TransparenciaSecao::where('slug', 'institucional')->firstOrFail();
    }

    public function test_visitante_sem_login_nao_acessa_o_painel(): void
    {
        $this->get(self::PAINEL)->assertRedirect('/login-adm');
    }

    public function test_painel_lista_as_secoes_e_documentos_iniciais(): void
    {
        $this->actingAs($this->editor())->get(self::PAINEL)
            ->assertOk()
            ->assertSee('Prestação de contas')
            ->assertSee('Estatuto Social consolidado');
    }

    public function test_cria_secao_com_apelido_gerado_pelo_titulo(): void
    {
        $this->actingAs($this->editor())->post(self::SECOES, [
            'titulo' => 'Editais e chamamentos',
            'subtitulo' => 'Processos abertos',
            'ordem' => 6,
        ])->assertRedirect(self::PAINEL);

        $this->assertDatabaseHas('transparencia_secoes', [
            'titulo' => 'Editais e chamamentos',
            'slug' => 'editais-e-chamamentos',
        ]);
    }

    public function test_secao_com_titulo_repetido_ganha_apelido_diferente(): void
    {
        $this->actingAs($this->editor())->post(self::SECOES, ['titulo' => 'Institucional']);

        $this->assertDatabaseHas('transparencia_secoes', ['slug' => 'institucional-2']);
    }

    public function test_cria_documento_com_pdf_e_o_site_mostra_o_botao_de_baixar(): void
    {
        $this->actingAs($this->editor())->post(self::DOCUMENTOS, [
            'secao_id' => $this->secao()->id,
            'nome' => 'Relatório de teste',
            'status' => 'publicado',
            'arquivo' => $this->pdf('relatorio.pdf'),
        ])->assertRedirect(self::PAINEL)->assertSessionHasNoErrors();

        $documento = TransparenciaDocumento::where('nome', 'Relatório de teste')->firstOrFail();
        $this->assertSame('relatorio.pdf', $documento->arquivo_nome);
        $this->assertStringStartsWith('%PDF', base64_decode($documento->arquivo_data));

        $this->get('/transparencia')
            ->assertSee('Baixar PDF')
            ->assertSee(route('transparencia.documento', $documento), false);
    }

    public function test_download_entrega_o_pdf_guardado_no_banco(): void
    {
        $documento = $this->secao()->documentos()->create([
            'nome' => 'Estatuto em PDF',
            'arquivo_nome' => 'estatuto.pdf',
            'arquivo_data' => base64_encode('%PDF-1.4 conteudo'),
        ]);

        $resposta = $this->get(route('transparencia.documento', $documento))->assertOk();

        $this->assertSame('application/pdf', $resposta->headers->get('Content-Type'));
        $this->assertStringContainsString('estatuto.pdf', $resposta->headers->get('Content-Disposition'));
        $this->assertSame('%PDF-1.4 conteudo', $resposta->getContent());
    }

    public function test_download_funciona_com_acento_e_simbolos_no_nome_do_arquivo(): void
    {
        $documento = $this->secao()->documentos()->create([
            'nome' => 'Relatório',
            'arquivo_nome' => 'relatório 100% final.pdf',
            'arquivo_data' => base64_encode('%PDF'),
        ]);

        $resposta = $this->get(route('transparencia.documento', $documento))->assertOk();

        $this->assertStringContainsString('relatorio_100__final.pdf', $resposta->headers->get('Content-Disposition'));
    }

    public function test_download_de_documento_sem_pdf_da_404(): void
    {
        $documento = TransparenciaDocumento::first();

        $this->get(route('transparencia.documento', $documento))->assertNotFound();
    }

    public function test_recusa_arquivo_que_nao_e_pdf(): void
    {
        $this->actingAs($this->editor())->post(self::DOCUMENTOS, [
            'secao_id' => $this->secao()->id,
            'nome' => 'Planilha',
            'status' => 'publicado',
            'arquivo' => UploadedFile::fake()->create('planilha.xlsx', 10),
        ])->assertSessionHasErrors('arquivo');

        $this->assertDatabaseMissing('transparencia_documentos', ['nome' => 'Planilha']);
    }

    public function test_documento_sem_nome_ou_sem_secao_nao_e_salvo(): void
    {
        $this->actingAs($this->editor())->post(self::DOCUMENTOS, [
            'status' => 'publicado',
        ])->assertSessionHasErrors(['nome', 'secao_id']);
    }

    public function test_edita_documento_e_remove_o_pdf(): void
    {
        $documento = $this->secao()->documentos()->create([
            'nome' => 'Com PDF',
            'arquivo_nome' => 'a.pdf',
            'arquivo_data' => base64_encode('%PDF'),
        ]);

        $this->actingAs($this->editor())->put(self::DOCUMENTOS . "/{$documento->id}", [
            'secao_id' => $documento->secao_id,
            'nome' => 'Sem PDF agora',
            'status' => 'elaboracao',
            'remover_arquivo' => '1',
        ])->assertRedirect(self::PAINEL);

        $documento->refresh();
        $this->assertSame('Sem PDF agora', $documento->nome);
        $this->assertFalse($documento->temArquivo());
        $this->assertNull($documento->arquivo_data);
    }

    public function test_editar_sem_enviar_pdf_mantem_o_arquivo_atual(): void
    {
        $documento = $this->secao()->documentos()->create([
            'nome' => 'Com PDF',
            'arquivo_nome' => 'a.pdf',
            'arquivo_data' => base64_encode('%PDF'),
        ]);

        $this->actingAs($this->editor())->put(self::DOCUMENTOS . "/{$documento->id}", [
            'secao_id' => $documento->secao_id,
            'nome' => 'Nome novo',
            'status' => 'publicado',
        ]);

        $this->assertTrue($documento->fresh()->temArquivo());
    }

    public function test_excluir_secao_apaga_os_documentos_dela(): void
    {
        $secao = $this->secao();
        $quantos = $secao->documentos()->count();
        $this->assertGreaterThan(0, $quantos);

        $this->actingAs($this->editor())->delete(self::SECOES . "/{$secao->id}")
            ->assertRedirect(self::PAINEL);

        $this->assertDatabaseMissing('transparencia_secoes', ['id' => $secao->id]);
        $this->assertSame(0, TransparenciaDocumento::where('secao_id', $secao->id)->count());
    }

    public function test_secao_sem_documentos_nao_aparece_no_site(): void
    {
        TransparenciaSecao::create(['slug' => 'vazia', 'titulo' => 'Seção vazia', 'ordem' => 99]);

        $this->get('/transparencia')->assertDontSee('Seção vazia');
    }
}
