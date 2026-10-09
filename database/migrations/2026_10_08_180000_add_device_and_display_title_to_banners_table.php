<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Banners do carrossel do topo em duas versões:
 * - device: "desktop" (computador) ou "mobile" (celular);
 * - width / height: tamanho da imagem (padrão 1920 × 700 e 600 × 700),
 *   usado como proporção do banner no site, para a imagem não ser cortada.
 *
 * "title" passa a ser só um nome interno (aparece no painel). O texto escrito
 * sobre a imagem no site fica em "display_title".
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('device', 10)->default('desktop');
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->string('display_title')->nullable();
        });

        // Banners que já existem: o título que aparecia no site continua aparecendo.
        DB::table('banners')->update(['display_title' => DB::raw('title')]);
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['device', 'width', 'height', 'display_title']);
        });
    }
};