<?php

namespace App\Console\Commands;

use App\Support\BackupBanco;
use Illuminate\Console\Command;
use Throwable;

class BancoRestaurar extends Command
{
    protected $signature = 'banco:restaurar
                            {arquivo : Arquivo .ndjson.gz gerado pelo banco:backup ou baixado em /adm/backup}
                            {--force : Não pede confirmação}';

    protected $description = 'Substitui os dados do banco pelos de um backup (rode "php artisan migrate" antes)';

    public function handle(BackupBanco $backup): int
    {
        $caminho = $this->argument('arquivo');

        if (! is_file($caminho)) {
            $this->error("Arquivo não encontrado: {$caminho}");

            return 1;
        }

        try {
            $cabecalho = $backup->lerCabecalho($caminho);
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return 1;
        }

        $this->line("Backup de {$cabecalho['gerado_em']} (banco de origem: {$cabecalho['driver']}).");
        $this->warn('Todos os dados atuais do site (inclusive usuários do painel) serão substituídos.');

        if (! $this->option('force') && ! $this->confirm('Continuar?')) {
            $this->line('Nada foi alterado.');

            return 1;
        }

        try {
            $contagem = $backup->restaurar($caminho);
        } catch (Throwable $e) {
            $this->error('Restauração cancelada, o banco não foi alterado: ' . $e->getMessage());

            return 1;
        }

        $this->table(['Tabela', 'Registros'], collect($contagem)->map(function ($total, $tabela) {
            return [$tabela, $total];
        })->values()->all());
        $this->info('Restauração concluída.');

        return 0;
    }
}
