<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manifestacoes_ouvidoria', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 30);                       // reclamacao, denuncia, sugestao...
            $table->boolean('anonimo')->default(false);
            $table->string('nome')->nullable();               // vazio quando anonimo
            $table->string('email')->nullable();
            $table->string('telefone', 30)->nullable();
            $table->text('mensagem');
            $table->string('status', 20)->default('recebida'); // recebida ou respondida
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manifestacoes_ouvidoria');
    }
};
