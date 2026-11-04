<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Marcos da linha do tempo ("Nossa história") da página Institucional,
 * cadastrados no painel em /adm/marcos.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marcos_institucionais', function (Blueprint $table) {
            $table->id();
            $table->string('data', 40);                  // como aparece no site, ex: Jul · 2025
            $table->text('texto');
            $table->unsignedInteger('ordem')->default(0);
            $table->timestamps();

            $table->index('ordem');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marcos_institucionais');
    }
};