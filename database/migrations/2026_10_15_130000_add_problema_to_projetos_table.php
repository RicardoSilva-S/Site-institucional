<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A tabela projetos já é criada por 2026_10_15_120000_create_projetos_table
 * (usada pela página /projetos e pelo painel). Esta migration só acrescenta o
 * campo "problema" da tabela do professor, sem recriar nada.
 *
 * É opcional (nullable) porque já existem projetos cadastrados e o painel
 * ainda não preenche esse campo.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Deploy repetido ou banco que já tem a coluna: não faz nada.
        if (Schema::hasColumn('projetos', 'problema')) {
            return;
        }

        Schema::table('projetos', function (Blueprint $table) {
            $table->text('problema')->nullable();   // texto de "O problema"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('projetos', 'problema')) {
            Schema::table('projetos', function (Blueprint $table) {
                $table->dropColumn('problema');
            });
        }
    }
};
