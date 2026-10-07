<?php

use App\Support\SiteContent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_texts', function (Blueprint $table) {
            $table->id();
            $table->string('page');           // shared, home, institucional...
            $table->string('group');          // hero, problem, footer...
            $table->string('group_label');    // nome da seção mostrado no painel
            $table->string('key')->unique();  // ex: home.hero.title
            $table->string('label');          // nome do campo mostrado no painel
            $table->text('value')->nullable();
            $table->boolean('long')->default(false);
            $table->boolean('custom')->default(false); // true = inserido pelo painel
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['page', 'group']);
        });

        // Copia todos os textos para a tabela nova. Os textos que já tinham
        // sido editados no painel antigo (tabela site_content_values) são
        // mantidos — nada do que está no site hoje se perde.
        SiteContent::sync();
    }

    public function down(): void
    {
        Schema::dropIfExists('site_texts');
    }
};