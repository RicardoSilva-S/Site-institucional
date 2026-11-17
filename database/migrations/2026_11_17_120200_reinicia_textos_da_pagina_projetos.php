<?php

use App\Support\SiteContent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * A página /projetos voltou ao formato do modelo antigo, com textos novos em
 * config/site_content.php. Os textos da página guardados no banco (com os
 * valores da versão anterior) são apagados para o site passar a mostrar os
 * novos; o painel recria os campos na próxima visita (SiteContent::sync).
 *
 * Só apaga os campos fixos da página. Textos INCLUÍDOS pelo painel
 * (custom = true) ficam como estão.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_texts')) {
            return;
        }

        DB::table('site_texts')
            ->where('page', 'projetos')
            ->where('custom', false)
            ->delete();

        // O sync() reaproveita os valores da tabela do painel antigo; sem
        // isto, ele traria de volta os textos da versão anterior.
        if (Schema::hasTable('site_content_values')) {
            DB::table('site_content_values')->where('key', 'like', 'projetos.%')->delete();
        }

        SiteContent::forget();
    }

    public function down(): void
    {
        // Nada a desfazer: os textos antigos saíram do config/site_content.php.
    }
};
