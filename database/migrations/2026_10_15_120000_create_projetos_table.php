<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Projetos e soluções da página /projetos (cartões do portfólio), cadastrados
 * pelo painel. Usa os mesmos nomes de coluna das migrations de projetos da
 * branch feat/banco-de-dados-projetos (titulo, breve_descricao, categorias,
 * estagio), com o que os cartões precisam a mais: tecnologia, link e ordem.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');                                 // ex: Totem de Autoatendimento
            $table->string('breve_descricao', 500);                   // texto do cartão
            $table->string('categorias')->nullable();                 // "Frente" no cartão
            $table->string('estagio', 30)->default('desenvolvimento'); // implementado, expansao, consultoria, piloto, desenvolvimento
            $table->string('tecnologia', 500)->nullable();
            $table->string('link_rotulo')->nullable();                // ex: Conhecer a solução
            $table->string('link_destino', 30)->default('contato');   // página para onde o link leva
            $table->unsignedInteger('ordem')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};
