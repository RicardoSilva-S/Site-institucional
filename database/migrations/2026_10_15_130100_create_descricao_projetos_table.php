<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Blocos de texto de cada projeto (título + texto), ex: "O que o Acquora faz".
 * Equivalente a sql/idtnpr_projetos_mysql.sql. Apagar o projeto apaga os
 * blocos dele (cascade), igual a transparencia_documentos.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('descricao_projetos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')
                ->constrained('projetos')
                ->cascadeOnDelete();
            $table->string('titulo');
            $table->text('texto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('descricao_projetos');
    }
};
