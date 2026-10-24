<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/**
 * Backup e restauração do banco do site, sem depender de mysqldump/pg_dump
 * (que não existem no Render gratuito nem em hospedagem só com FTP).
 *
 * O arquivo é um .ndjson.gz: uma linha JSON por registro, compactado.
 *   1ª linha: {"formato":"idtnpr-backup","versao":1,"driver":"pgsql",...}
 *   demais:   {"t":"editais","r":{...colunas do registro...}}
 *
 * Como só guarda dados (não o "CREATE TABLE"), o mesmo arquivo restaura em
 * MySQL, Postgres ou SQLite — serve também para migrar o site do Render
 * (Postgres) para outra hospedagem (MySQL). Antes de restaurar, rode
 * `php artisan migrate` no destino para as tabelas existirem.
 *
 * Usado por `php artisan banco:backup`, `php artisan banco:restaurar` e pela
 * tela /adm/backup do painel.
 */
class BackupBanco
{
    const FORMATO = 'idtnpr-backup';
    const VERSAO = 1;

    /** Tabelas que não entram no backup: controle do Laravel e sessões. */
    const IGNORADAS = ['migrations', 'sessions'];

    /** Quantos registros por INSERT na restauração (PDFs em base64 são grandes). */
    const LOTE = 20;

    /**
     * Grava o backup em $caminho e devolve quantos registros cada tabela teve.
     *
     * @return array<string,int>
     */
    public function gerar(string $caminho): array
    {
        $pasta = dirname($caminho);
        if (! is_dir($pasta)) {
            mkdir($pasta, 0775, true);
        }

        $arquivo = gzopen($caminho, 'wb6');
        if ($arquivo === false) {
            throw new RuntimeException("Não foi possível criar o arquivo {$caminho}.");
        }

        $tabelas = $this->tabelas();
        $contagem = [];

        try {
            $this->escrever($arquivo, [
                'formato' => self::FORMATO,
                'versao' => self::VERSAO,
                'gerado_em' => now()->toIso8601String(),
                'driver' => DB::getDriverName(),
                'tabelas' => $tabelas,
                'migrations' => DB::table('migrations')->orderBy('id')->pluck('migration')->all(),
            ]);

            foreach ($tabelas as $tabela) {
                $contagem[$tabela] = 0;

                // cursor() lê um registro por vez: não carrega todos os PDFs na memória
                foreach ($this->consultaOrdenada($tabela)->cursor() as $registro) {
                    $this->escrever($arquivo, ['t' => $tabela, 'r' => (array) $registro]);
                    $contagem[$tabela]++;
                }
            }
        } finally {
            gzclose($arquivo);
        }

        return $contagem;
    }

    /**
     * Apaga os dados atuais e coloca os do backup no lugar, tudo numa
     * transação: se der erro no meio, o banco volta como estava.
     *
     * @return array<string,int> registros restaurados por tabela
     */
    public function restaurar(string $caminho): array
    {
        $cabecalho = $this->lerCabecalho($caminho);

        $existentes = $this->tabelas();
        $faltando = array_values(array_diff($cabecalho['tabelas'], $existentes));
        if ($faltando) {
            throw new RuntimeException(
                'O banco não tem as tabelas ' . implode(', ', $faltando)
                . '. Rode "php artisan migrate" antes de restaurar.'
            );
        }

        // Só mexe nas tabelas que estão no backup, na ordem pai -> filho.
        $tabelas = array_values(array_intersect($existentes, $cabecalho['tabelas']));
        $colunas = [];
        $booleanas = [];
        foreach ($tabelas as $tabela) {
            $colunas[$tabela] = array_flip(Schema::getColumnListing($tabela));
            $booleanas[$tabela] = $this->colunasBooleanas($tabela);
        }

        $contagem = array_fill_keys($tabelas, 0);

        DB::transaction(function () use ($caminho, $tabelas, $colunas, $booleanas, &$contagem) {
            // filhos primeiro, para não violar chave estrangeira
            foreach (array_reverse($tabelas) as $tabela) {
                DB::table($tabela)->delete();
            }

            // Uma passada pelo arquivo para cada tabela, sempre na ordem pai -> filho
            // do banco atual. Assim a filha nunca é gravada antes da pai, mesmo quando
            // ela tem mais linhas que o lote ou o arquivo vem em outra ordem.
            foreach ($tabelas as $tabela) {
                $contagem[$tabela] = $this->restaurarTabela($caminho, $tabela, $colunas[$tabela], $booleanas[$tabela]);
            }

            $this->ajustarSequencias($tabelas);
        });

        return $contagem;
    }

    /**
     * Grava no banco, em lotes, os registros de $tabela que estão no arquivo.
     *
     * @param array<string,int> $colunas   colunas que existem hoje na tabela (nome => posição)
     * @param string[]          $booleanas colunas booleanas da tabela
     * @return int quantos registros foram gravados
     */
    private function restaurarTabela(string $caminho, string $tabela, array $colunas, array $booleanas): int
    {
        $lote = [];
        $total = 0;

        foreach ($this->registros($caminho, $tabela) as $linha) {
            // Colunas que não existem mais no banco são ignoradas; as novas
            // ficam com o valor padrão da migration.
            $registro = array_intersect_key($linha['r'], $colunas);
            foreach ($booleanas as $coluna) {
                if (array_key_exists($coluna, $registro) && $registro[$coluna] !== null) {
                    $registro[$coluna] = (bool) $registro[$coluna];
                }
            }

            $lote[] = $registro;
            $total++;

            if (count($lote) >= self::LOTE) {
                DB::table($tabela)->insert($lote);
                $lote = [];
            }
        }

        if (! empty($lote)) {
            DB::table($tabela)->insert($lote);
        }

        return $total;
    }

    /**
     * Lê e valida a 1ª linha do arquivo.
     */
    public function lerCabecalho(string $caminho): array
    {
        foreach ($this->linhas($caminho) as $linha) {
            if (($linha['formato'] ?? null) !== self::FORMATO || ! isset($linha['tabelas'])) {
                break;
            }
            if ((int) $linha['versao'] > self::VERSAO) {
                throw new RuntimeException('Backup feito por uma versão mais nova do site.');
            }

            return $linha;
        }

        throw new RuntimeException('Arquivo inválido: não é um backup do site IDTNPR.');
    }

    /**
     * Tabelas do banco (sem as ignoradas), com as tabelas "pai" antes das
     * "filhas" (ex: transparencia_secoes antes de transparencia_documentos).
     *
     * @return string[]
     */
    public function tabelas(): array
    {
        $tabelas = array_values(array_diff($this->listarTabelas(), self::IGNORADAS));
        sort($tabelas);

        $dependencias = $this->dependencias($tabelas);
        $ordenadas = [];
        $visitando = [];

        $visitar = function ($tabela) use (&$visitar, &$ordenadas, &$visitando, $dependencias) {
            if (in_array($tabela, $ordenadas, true) || isset($visitando[$tabela])) {
                return;
            }
            $visitando[$tabela] = true;
            foreach ($dependencias[$tabela] ?? [] as $pai) {
                $visitar($pai);
            }
            $ordenadas[] = $tabela;
        };

        foreach ($tabelas as $tabela) {
            $visitar($tabela);
        }

        return $ordenadas;
    }

    // ---------------------------------------------------------------------

    private function escrever($arquivo, array $dados): void
    {
        $json = json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
        gzwrite($arquivo, $json . "\n");
    }

    /**
     * Lê o arquivo linha a linha, sem carregar tudo na memória. Com $prefixo,
     * só devolve as linhas que começam por ele.
     */
    private function linhas(string $caminho, ?string $prefixo = null): \Generator
    {
        $arquivo = @gzopen($caminho, 'rb');
        if ($arquivo === false) {
            throw new RuntimeException('Não foi possível abrir o arquivo de backup.');
        }

        try {
            while (($texto = gzgets($arquivo)) !== false) {
                // gzgets corta em 8 KB sem esse limite; os PDFs em base64 são maiores
                while (substr($texto, -1) !== "\n" && ! gzeof($arquivo)) {
                    $texto .= gzgets($arquivo, 1024 * 1024);
                }
                $texto = trim($texto);
                if ($texto === '') {
                    continue;
                }
                // Com $prefixo, só decodifica as linhas da tabela pedida: sem isso cada
                // passada decodificaria de novo todos os PDFs em base64.
                if ($prefixo !== null && strncmp($texto, $prefixo, strlen($prefixo)) !== 0) {
                    continue;
                }
                $linha = json_decode($texto, true);
                if (! is_array($linha)) {
                    throw new RuntimeException('Arquivo de backup corrompido.');
                }
                yield $linha;
            }
        } finally {
            gzclose($arquivo);
        }
    }

    /** Só as linhas de registro (pula o cabeçalho). Com $tabela, só as dela. */
    private function registros(string $caminho, ?string $tabela = null): \Generator
    {
        // Mesmo formato que escrever() grava: {"t":"tabela","r":{...}}
        $prefixo = $tabela === null ? null : '{"t":' . json_encode($tabela) . ',"r":';

        foreach ($this->linhas($caminho, $prefixo) as $linha) {
            if (isset($linha['t'], $linha['r'])) {
                yield $linha;
            }
        }
    }

    private function consultaOrdenada(string $tabela)
    {
        $consulta = DB::table($tabela);

        return Schema::hasColumn($tabela, 'id') ? $consulta->orderBy('id') : $consulta;
    }

    /** @return string[] */
    private function listarTabelas(): array
    {
        switch (DB::getDriverName()) {
            case 'mysql':
                $linhas = DB::select('select table_name as nome from information_schema.tables where table_schema = database() and table_type = ?', ['BASE TABLE']);
                break;
            case 'pgsql':
                $linhas = DB::select('select tablename as nome from pg_tables where schemaname = current_schema()');
                break;
            case 'sqlite':
                $linhas = DB::select("select name as nome from sqlite_master where type = 'table' and name not like 'sqlite_%'");
                break;
            default:
                throw new RuntimeException('Banco não suportado: ' . DB::getDriverName());
        }

        return array_map(function ($linha) {
            return (string) ($linha->nome ?? $linha->NOME ?? $linha->TABLE_NAME);
        }, $linhas);
    }

    /**
     * Para cada tabela, as tabelas que ela referencia por chave estrangeira.
     *
     * @return array<string,string[]>
     */
    private function dependencias(array $tabelas): array
    {
        $deps = [];

        switch (DB::getDriverName()) {
            case 'mysql':
                $linhas = DB::select('select table_name as filha, referenced_table_name as pai from information_schema.key_column_usage where table_schema = database() and referenced_table_name is not null');
                break;
            case 'pgsql':
                $linhas = DB::select("select tc.table_name as filha, ccu.table_name as pai
                    from information_schema.table_constraints tc
                    join information_schema.constraint_column_usage ccu
                      on ccu.constraint_name = tc.constraint_name and ccu.constraint_schema = tc.constraint_schema
                    where tc.constraint_type = 'FOREIGN KEY' and tc.table_schema = current_schema()");
                break;
            default: // sqlite
                $linhas = [];
                foreach ($tabelas as $tabela) {
                    foreach (DB::select('PRAGMA foreign_key_list("' . str_replace('"', '', $tabela) . '")') as $fk) {
                        $linhas[] = (object) ['filha' => $tabela, 'pai' => $fk->table];
                    }
                }
        }

        foreach ($linhas as $linha) {
            $filha = (string) ($linha->filha ?? $linha->FILHA);
            $pai = (string) ($linha->pai ?? $linha->PAI);
            if ($filha !== $pai) {
                $deps[$filha][] = $pai;
            }
        }

        return $deps;
    }

    /**
     * No Postgres, 1 vira inteiro e não entra em coluna boolean; por isso
     * convertemos (um backup do MySQL/SQLite guarda booleano como 0/1).
     *
     * @return string[]
     */
    private function colunasBooleanas(string $tabela): array
    {
        if (DB::getDriverName() !== 'pgsql') {
            return [];
        }

        return array_map(function ($linha) {
            return $linha->column_name;
        }, DB::select("select column_name from information_schema.columns where table_schema = current_schema() and table_name = ? and data_type = 'boolean'", [$tabela]));
    }

    /**
     * Depois de inserir com id fixo, o Postgres precisa saber qual é o próximo
     * id; senão o próximo cadastro no painel dá "duplicate key".
     */
    private function ajustarSequencias(array $tabelas): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        foreach ($tabelas as $tabela) {
            if (! Schema::hasColumn($tabela, 'id')) {
                continue;
            }
            $sequencia = DB::selectOne('select pg_get_serial_sequence(?, ?) as nome', [$tabela, 'id'])->nome;
            if ($sequencia) {
                DB::select("select setval(?, coalesce((select max(id) from \"{$tabela}\"), 0) + 1, false)", [$sequencia]);
            }
        }
    }
}
