<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * A dica "Arraste para o lado para ver as cinco etapas" saiu da página
 * inicial (as etapas agora têm setas). Apaga o texto do banco para ele não
 * continuar aparecendo no painel.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_texts')) {
            DB::table('site_texts')->where('key', 'home.steps.hint')->delete();
        }
    }

    public function down(): void
    {
        // Nada a desfazer: o campo saiu do config/site_content.php.
    }
};