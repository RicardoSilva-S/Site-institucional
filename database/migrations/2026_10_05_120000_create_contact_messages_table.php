<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cargo')->nullable();
            $table->string('orgao');
            $table->string('email')->nullable();
            $table->string('telefone', 30)->nullable();
            $table->string('area')->nullable();
            $table->text('mensagem');
            // Preenchido quando alguém do painel marca a mensagem como lida.
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
