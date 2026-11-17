<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Página /projetos no formato do modelo antigo (idtnpr.org.br/projetos.html):
 * cada cartão tem um ícone e um "Ver detalhes" que leva a /projetos/{slug}.
 *
 *   slug  -> endereço da página de detalhe (gerado do título pelo model)
 *   icone -> chave de um dos ícones de Projeto::ICONES
 *
 * Os projetos que já existem ganham um slug feito a partir do título.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('projetos', 'slug')) {
            Schema::table('projetos', function (Blueprint $table) {
                $table->string('slug', 120)->nullable()->unique()->after('titulo');
            });
        }

        if (! Schema::hasColumn('projetos', 'icone')) {
            Schema::table('projetos', function (Blueprint $table) {
                $table->string('icone', 30)->nullable()->after('categorias');
            });
        }

        $usados = [];

        foreach (DB::table('projetos')->whereNull('slug')->orderBy('id')->get(['id', 'titulo']) as $projeto) {
            $base = Str::slug($projeto->titulo) ?: 'projeto';
            $slug = $base;

            for ($n = 2; in_array($slug, $usados, true) || DB::table('projetos')->where('slug', $slug)->exists(); $n++) {
                $slug = "{$base}-{$n}";
            }

            $usados[] = $slug;
            DB::table('projetos')->where('id', $projeto->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('projetos', 'slug')) {
            Schema::table('projetos', function (Blueprint $table) {
                $table->dropUnique(['slug']);
            });
        }

        // Um único dropColumn por chamada: o SQLite não aceita dois.
        $colunas = array_values(array_filter(['slug', 'icone'], fn ($c) => Schema::hasColumn('projetos', $c)));

        if ($colunas) {
            Schema::table('projetos', function (Blueprint $table) use ($colunas) {
                $table->dropColumn($colunas);
            });
        }
    }
};
