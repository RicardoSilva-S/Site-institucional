<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transparencia_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secao_id')
                ->constrained('transparencia_secoes')
                ->cascadeOnDelete();
            $table->string('nome');
            $table->string('detalhe')->nullable();
            $table->string('status', 20)->default('publicado');
            $table->string('arquivo_nome')->nullable();   // nome original do PDF, ex: estatuto.pdf
            $table->longText('arquivo_data')->nullable(); // conteúdo do PDF em base64
            $table->unsignedInteger('ordem')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transparencia_documentos');
    }
};
