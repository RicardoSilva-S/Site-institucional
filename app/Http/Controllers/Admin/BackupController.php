<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\BackupBanco;
use Illuminate\Http\Request;
use Throwable;

/**
 * /adm/backup — baixar e restaurar o backup do banco pelo painel.
 * No Render gratuito e na hospedagem por FTP não há terminal, então esta
 * tela faz o mesmo que `php artisan banco:backup` / `banco:restaurar`.
 * Só administradores acessam (middleware "admin" na rota).
 */
class BackupController extends Controller
{
    public function index(BackupBanco $backup)
    {
        return view('admin.backup', ['tabelas' => $backup->tabelas()]);
    }

    public function baixar(BackupBanco $backup)
    {
        $nome = 'backup-idtnpr-' . now()->format('Y-m-d-His') . '.ndjson.gz';
        $caminho = tempnam(sys_get_temp_dir(), 'backup');

        $backup->gerar($caminho);

        return response()->download($caminho, $nome, ['Content-Type' => 'application/gzip'])
            ->deleteFileAfterSend(true);
    }

    public function restaurar(Request $request, BackupBanco $backup)
    {
        // 40 MB de propósito: o backup guarda os PDFs em base64 e é enviado inteiro.
        // A rota é só de administradores (middleware "admin") e exige confirmação.
        $request->validate([
            'arquivo' => ['required', 'file', 'max:40960'], // NOSONAR php:S5693 limite revisado
            'confirmacao' => ['required', 'in:RESTAURAR'],
        ], [
            'arquivo.required' => 'Escolha o arquivo de backup.',
            'arquivo.file' => 'O envio do arquivo falhou. Ele pode ser maior que o limite do servidor.',
            'arquivo.max' => 'O backup passa de 40 MB.',
            'confirmacao.*' => 'Digite RESTAURAR para confirmar.',
        ]);

        try {
            $contagem = $backup->restaurar($request->file('arquivo')->getRealPath());
        } catch (Throwable $e) {
            report($e);

            return back()->withErrors(['arquivo' => 'Restauração cancelada, nada foi alterado: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.backup.index')
            ->with('status', 'Backup restaurado: ' . array_sum($contagem) . ' registros em ' . count($contagem) . ' tabelas.');
    }
}
