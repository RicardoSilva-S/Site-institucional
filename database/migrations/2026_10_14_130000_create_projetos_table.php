<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Projetos da página /projetos. Equivalente a sql/idtnpr_projetos_mysql.sql
 * (branch feat/banco-de-dados-projetos), mas roda em MySQL, Postgres e SQLite.
 * Os blocos de texto de cada projeto ficam em descricao_projetos (1 : N).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');                                    // ex: Acquora
            $table->string('breve_descricao', 500);                      // frase curta do cartão
            $table->string('categorias');                                // ex: Saneamento
            $table->string('estagio', 30)->default('em_desenvolvimento'); // disponivel ou em_desenvolvimento
            $table->text('problema');                                    // texto de "O problema"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};
