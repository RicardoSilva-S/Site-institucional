<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Editais e chamamentos públicos (página /editais), cadastrados pelo painel.
 * O PDF do edital fica no banco (base64), igual aos documentos da
 * transparência: no Render gratuito o disco é apagado quando o servidor
 * reinicia.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('editais', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('resumo')->nullable();
            $table->string('status', 20)->default('aberto');    // aberto, analise ou encerrado
            $table->date('abertura')->nullable();
            $table->date('encerramento')->nullable();
            $table->string('arquivo_nome')->nullable();          // nome original do PDF
            $table->longText('arquivo_data')->nullable();        // conteúdo do PDF em base64
            $table->timestamps();

            $table->index(['status', 'abertura']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('editais');
    }
};
