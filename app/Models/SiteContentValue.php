<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Um texto editável do site, identificado por uma "key" única
 * (ex: "home.hero.title" — ver config/site_content.php).
 *
 * Só existe uma linha aqui quando o texto padrão foi substituído pelo
 * painel /admin/conteudo. Sem linha = usa o "default" do config.
 */
class SiteContentValue extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];
}
