<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * As migrations precisam subir e descer limpas, porque o deploy roda
 * `php artisan migrate --force` (docker/start.sh). Aqui roda no SQLite; o
 * workflow .github/workflows/migrations.yml roda o mesmo em MySQL e Postgres
 * com PHP 7.4.
 */
class MigrationsTest extends TestCase
{
    public function test_migrations_criam_as_tabelas_e_os_dados_iniciais()
    {
        Artisan::call('migrate:fresh');

        foreach ([
            'users', 'site_texts', 'banners', 'contact_messages',
            'transparencia_secoes', 'transparencia_documentos',
            'membros_institucionais', 'manifestacoes_ouvidoria', 'editais',
            'projetos', 'descricao_projetos',
        ] as $tabela) {
            $this->assertTrue(Schema::hasTable($tabela), "Falta a tabela {$tabela}");
        }

        $this->assertTrue(Schema::hasColumns('users', ['papel', 'ativo', 'ultimo_login']));
        $this->assertSame(18, DB::table('transparencia_documentos')->count());
        $this->assertSame(6, DB::table('membros_institucionais')->count());
        $this->assertSame(4, DB::table('editais')->count());
    }

    public function test_apagar_projeto_apaga_os_blocos_de_descricao()
    {
        Artisan::call('migrate:fresh');
        $agora = now();

        $projetoId = DB::table('projetos')->insertGetId([
            'titulo' => 'Acquora',
            'breve_descricao' => 'Gestão de saneamento',
            'categorias' => 'Saneamento',
            'problema' => 'Perdas de água sem controle.',
            'created_at' => $agora,
            'updated_at' => $agora,
        ]);
        DB::table('descricao_projetos')->insert([
            ['projeto_id' => $projetoId, 'titulo' => 'O que o Acquora faz', 'texto' => 'Monitora a rede.', 'created_at' => $agora, 'updated_at' => $agora],
            ['projeto_id' => $projetoId, 'titulo' => 'Para quem é', 'texto' => 'Prefeituras.', 'created_at' => $agora, 'updated_at' => $agora],
        ]);

        $this->assertSame('desenvolvimento', DB::table('projetos')->where('id', $projetoId)->value('estagio'));
        $this->assertSame(2, DB::table('descricao_projetos')->where('projeto_id', $projetoId)->count());

        DB::table('projetos')->where('id', $projetoId)->delete();

        $this->assertSame(0, DB::table('descricao_projetos')->count());
    }

    public function test_migrations_rodam_duas_vezes_sem_duplicar_dados()
    {
        Artisan::call('migrate:fresh');
        $documentos = DB::table('transparencia_documentos')->count();

        Artisan::call('migrate'); // deploy repetido não pode duplicar nada

        $this->assertSame($documentos, DB::table('transparencia_documentos')->count());
    }

    public function test_rollback_completo_e_migrate_de_novo()
    {
        if (! class_exists(\Doctrine\DBAL\Driver\AbstractSQLiteDriver::class)) {
            $this->markTestSkipped('No SQLite, dropColumn precisa do doctrine/dbal: composer require --dev doctrine/dbal:^3.1.4');
        }

        Artisan::call('migrate:fresh');
        $this->assertSame(0, Artisan::call('migrate:reset'));
        $this->assertFalse(Schema::hasTable('editais'));

        $this->assertSame(0, Artisan::call('migrate'));
        $this->assertSame(4, DB::table('editais')->count());
    }
}
