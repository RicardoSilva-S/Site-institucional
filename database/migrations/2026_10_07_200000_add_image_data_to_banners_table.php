<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Guarda a imagem do banner dentro do banco (em base64), em vez de um
 * arquivo em public/uploads. No Render gratuito o disco é apagado sempre que
 * o servidor reinicia (ou "dorme" e acorda), e a imagem sumia. No banco
 * (PostgreSQL) ela fica guardada para sempre.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('image_mime', 50)->nullable();  // ex: image/jpeg
            $table->longText('image_data')->nullable();    // conteúdo da imagem em base64
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['image_mime', 'image_data']);
        });
    }
};