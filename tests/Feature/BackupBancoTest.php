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
}
