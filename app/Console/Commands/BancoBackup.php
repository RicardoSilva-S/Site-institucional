<?php

namespace App\Console\Commands;

use App\Support\BackupBanco;
use Illuminate\Console\Command;

class BancoBackup extends Command
{
    protected $signature = 'banco:backup
                            {--arquivo= : Caminho do arquivo (padrão: storage/app/backups/backup-AAAA-MM-DD-HHMMSS.ndjson.gz)}';

    protected $description = 'Gera um backup de todos os dados do site (funciona em MySQL, Postgres e SQLite)';

    public function handle(BackupBanco $backup): int
    {
        $caminho = $this->option('arquivo')
            ?: storage_path('app/backups/backup-' . now()->format('Y-m-d-His') . '.ndjson.gz');

        $contagem = $backup->gerar($caminho);

        $this->table(['Tabela', 'Registros'], collect($contagem)->map(function ($total, $tabela) {
            return [$tabela, $total];
        })->values()->all());

        $this->info('Backup salvo em ' . $caminho . ' (' . number_format(filesize($caminho) / 1024, 1, ',', '.') . ' KB)');

        return 0;
    }
}
