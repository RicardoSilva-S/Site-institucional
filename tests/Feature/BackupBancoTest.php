<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\BackupBanco;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BackupBancoTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['papel' => User::PAPEL_ADMIN, 'email' => 'admin@idtnpr.org.br']);
    }

    private function arquivoTemporario(): string
    {
        return tempnam(sys_get_temp_dir(), 'teste-backup');
    }

    public function test_backup_e_restauracao_devolvem_os_mesmos_dados()
    {
        $this->admin();
        $backup = app(BackupBanco::class);
        $caminho = $this->arquivoTemporario();

        $antes = [
            'documentos' => DB::table('transparencia_documentos')->orderBy('id')->get()->toArray(),
            'editais' => DB::table('editais')->count(),
            'membros' => DB::table('membros_institucionais')->count(),
        ];
        $this->assertGreaterThan(0, $antes['editais']);

        $contagem = $backup->gerar($caminho);
        $this->assertSame(1, $contagem['users']);
        $this->assertArrayNotHasKey('migrations', $contagem);

        // estraga os dados depois do backup
        DB::table('editais')->delete();
        DB::table('transparencia_documentos')->update(['nome' => 'alterado']);
        DB::table('users')->insert(['name' => 'Intruso', 'email' => 'x@x.com', 'password' => 'x']);

        $backup->restaurar($caminho);

        $this->assertEquals($antes['documentos'], DB::table('transparencia_documentos')->orderBy('id')->get()->toArray());
        $this->assertSame($antes['editais'], DB::table('editais')->count());
        $this->assertSame($antes['membros'], DB::table('membros_institucionais')->count());
        $this->assertSame(['admin@idtnpr.org.br'], DB::table('users')->pluck('email')->all());

        unlink($caminho);
    }

    public function test_tabela_pai_vem_antes_da_filha()
    {
        $tabelas = app(BackupBanco::class)->tabelas();

        $this->assertLessThan(
            array_search('transparencia_documentos', $tabelas),
            array_search('transparencia_secoes', $tabelas)
        );
    }

    public function test_arquivo_que_nao_e_backup_e_recusado_sem_mexer_no_banco()
    {
        $caminho = $this->arquivoTemporario();
        file_put_contents($caminho, gzencode("{\"qualquer\":1}\n"));
        $editais = DB::table('editais')->count();

        try {
            app(BackupBanco::class)->restaurar($caminho);
            $this->fail('Deveria recusar o arquivo.');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString('não é um backup', $e->getMessage());
        }

        $this->assertSame($editais, DB::table('editais')->count());
        unlink($caminho);
    }

    public function test_painel_baixa_e_restaura_o_backup()
    {
        $admin = $this->admin();

        $resposta = $this->actingAs($admin)->get('/adm/backup/baixar');
        $resposta->assertOk();
        $this->assertStringContainsString('backup-idtnpr-', $resposta->headers->get('content-disposition'));

        $caminho = $this->arquivoTemporario();
        copy($resposta->getFile()->getPathname(), $caminho);

        DB::table('editais')->delete();

        $this->actingAs($admin)->post('/adm/backup/restaurar', [
            'arquivo' => new UploadedFile($caminho, 'backup.ndjson.gz', 'application/gzip', null, true),
            'confirmacao' => 'RESTAURAR',
        ])->assertRedirect('/adm/backup')->assertSessionHas('status');

        $this->assertGreaterThan(0, DB::table('editais')->count());
    }

    public function test_restaurar_exige_confirmacao()
    {
        $caminho = $this->arquivoTemporario();
        app(BackupBanco::class)->gerar($caminho);

        $this->actingAs($this->admin())->from('/adm/backup')->post('/adm/backup/restaurar', [
            'arquivo' => new UploadedFile($caminho, 'backup.ndjson.gz', 'application/gzip', null, true),
            'confirmacao' => 'sim',
        ])->assertRedirect('/adm/backup')->assertSessionHasErrors('confirmacao');
    }

    public function test_editor_nao_acessa_o_backup_nem_ve_o_menu()
    {
        $editor = User::factory()->create(['papel' => User::PAPEL_EDITOR]);

        $this->actingAs($editor)->get('/adm/backup')->assertForbidden();
        $this->actingAs($editor)->get('/adm/backup/baixar')->assertForbidden();
        $this->actingAs($editor)->get('/adm/paginas/home')->assertDontSee('Backup do banco');
    }

    public function test_admin_ve_a_tela_de_backup()
    {
        $this->actingAs($this->admin())->get('/adm/backup')
            ->assertOk()
            ->assertSee('Baixar backup agora')
            ->assertSee('Backup do banco');
    }

    /**
     * Completa a tabela de documentos até $total linhas (o seed traz 18), todos
     * na primeira seção. As seções continuam sendo poucas.
     */
    private function documentosAte(int $total): void
    {
        $secaoId = DB::table('transparencia_secoes')->orderBy('id')->value('id');
        $agora = now();

        for ($n = DB::table('transparencia_documentos')->count() + 1; $n <= $total; $n++) {
            DB::table('transparencia_documentos')->insert([
                'secao_id' => $secaoId,
                'nome' => "Documento extra {$n}",
                'status' => 'publicado',
                'ordem' => 100 + $n,
                'created_at' => $agora,
                'updated_at' => $agora,
            ]);
        }
    }

    public function totaisDeDocumentos(): array
    {
        return [
            'exatamente um lote' => [BackupBanco::LOTE],
            'passa do lote' => [BackupBanco::LOTE + 5],
            'dois lotes' => [BackupBanco::LOTE * 2],
        ];
    }

    /**
     * A tabela filha (documentos) pode ter mais linhas que o lote enquanto a
     * pai (seções) tem menos. A restauração não pode gravar a filha antes da pai.
     *
     * @dataProvider totaisDeDocumentos
     */
    public function test_restaura_quando_a_filha_tem_mais_linhas_que_o_lote($total)
    {
        $this->documentosAte($total);
        $this->assertLessThan(BackupBanco::LOTE, DB::table('transparencia_secoes')->count());
        $antes = DB::table('transparencia_documentos')->orderBy('id')->get()->toArray();
        $this->assertCount($total, $antes);

        $backup = app(BackupBanco::class);
        $caminho = $this->arquivoTemporario();
        $backup->gerar($caminho);
        DB::table('transparencia_documentos')->delete();

        $contagem = $backup->restaurar($caminho);

        $this->assertSame($total, $contagem['transparencia_documentos']);
        $this->assertEquals($antes, DB::table('transparencia_documentos')->orderBy('id')->get()->toArray());
        unlink($caminho);
    }

    public function test_restaura_mesmo_quando_o_arquivo_traz_a_filha_antes_da_pai()
    {
        $this->documentosAte(BackupBanco::LOTE + 5);
        $secoes = DB::table('transparencia_secoes')->orderBy('id')->get()->toArray();
        $documentos = DB::table('transparencia_documentos')->orderBy('id')->get()->toArray();

        $backup = app(BackupBanco::class);
        $caminho = $this->arquivoTemporario();
        $backup->gerar($caminho);

        // refaz o arquivo com as linhas dos documentos antes das linhas das seções
        $linhas = gzfile($caminho);
        $cabecalho = array_shift($linhas);
        $daSecao = $dosDocumentos = $demais = [];
        foreach ($linhas as $linha) {
            if (strpos($linha, '{"t":"transparencia_secoes"') === 0) {
                $daSecao[] = $linha;
            } elseif (strpos($linha, '{"t":"transparencia_documentos"') === 0) {
                $dosDocumentos[] = $linha;
            } else {
                $demais[] = $linha;
            }
        }
        $this->assertNotEmpty($daSecao);
        file_put_contents($caminho, gzencode($cabecalho . implode('', $dosDocumentos) . implode('', $daSecao) . implode('', $demais)));

        $backup->restaurar($caminho);

        $this->assertEquals($secoes, DB::table('transparencia_secoes')->orderBy('id')->get()->toArray());
        $this->assertEquals($documentos, DB::table('transparencia_documentos')->orderBy('id')->get()->toArray());
        unlink($caminho);
    }

    public function test_restauracao_nao_junta_pdfs_grandes_num_unico_insert()
    {
        // 3 PDFs de 3 MB nos 3 primeiros documentos: juntos passam do teto de bytes
        $pdf = str_repeat('A', 3 * 1024 * 1024);
        $ids = DB::table('transparencia_documentos')->orderBy('id')->limit(3)->pluck('id');
        DB::table('transparencia_documentos')->whereIn('id', $ids)->update(['arquivo_nome' => 'a.pdf', 'arquivo_data' => $pdf]);
        $this->assertLessThan(BackupBanco::LOTE, DB::table('transparencia_documentos')->count());
        $this->assertGreaterThan(BackupBanco::LOTE_BYTES, 3 * strlen($pdf));
        $antes = DB::table('transparencia_documentos')->orderBy('id')->get()->toArray();

        $backup = app(BackupBanco::class);
        $caminho = $this->arquivoTemporario();
        $backup->gerar($caminho);

        $inserts = 0;
        DB::listen(function ($consulta) use (&$inserts) {
            if (strpos($consulta->sql, 'insert into "transparencia_documentos"') === 0) {
                $inserts++;
            }
        });
        $backup->restaurar($caminho);

        // só pela quantidade de linhas (menos que LOTE) seria 1 insert; pelos bytes são 2
        $this->assertSame(2, $inserts);
        $this->assertEquals($antes, DB::table('transparencia_documentos')->orderBy('id')->get()->toArray());
        unlink($caminho);
    }

    public function test_painel_aceita_backup_acima_de_5_mb_e_recusa_acima_de_40_mb()
    {
        $admin = $this->admin();

        // 6 MB passa na validação do tamanho (o conteúdo falso é recusado depois, como backup inválido)
        $resposta = $this->actingAs($admin)->from('/adm/backup')->post('/adm/backup/restaurar', [
            'arquivo' => UploadedFile::fake()->create('backup.ndjson.gz', 6 * 1024),
            'confirmacao' => 'RESTAURAR',
        ]);
        $resposta->assertSessionHasErrors('arquivo');
        $this->assertStringNotContainsString('passa de', session('errors')->first('arquivo'));

        $this->actingAs($admin)->from('/adm/backup')->post('/adm/backup/restaurar', [
            'arquivo' => UploadedFile::fake()->create('backup.ndjson.gz', 41 * 1024),
            'confirmacao' => 'RESTAURAR',
        ])->assertSessionHasErrors(['arquivo' => 'O backup passa de 40 MB.']);
    }
}
