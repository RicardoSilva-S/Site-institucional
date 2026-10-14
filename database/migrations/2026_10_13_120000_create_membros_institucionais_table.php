<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Diretoria e conselho da página Institucional, editados pelo painel.
 * A foto fica no banco (base64), igual às imagens dos banners: no Render
 * gratuito o disco é apagado quando o servidor reinicia.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membros_institucionais', function (Blueprint $table) {
            $table->id();
            $table->string('grupo', 20);                         // diretoria ou conselho
            $table->string('nome');
            $table->string('cargo');
            $table->text('bio')->nullable();                     // texto curto do cartão (diretoria)
            $table->string('foto_nome')->nullable();             // nome original, ex: jonny.jpg
            $table->string('foto_mime', 50)->nullable();         // ex: image/jpeg
            $table->longText('foto_data')->nullable();           // conteúdo da foto em base64
            $table->boolean('foto_aproximada')->default(false);  // amplia a foto no cartão
            $table->unsignedInteger('ordem')->default(0);
            $table->timestamps();

            $table->index(['grupo', 'ordem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membros_institucionais');
    }
};
