<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Um texto do site, editável pelo painel /adm.
 *
 * - Textos originais (custom = false) vêm de config/site_content.php e são
 *   exibidos na view por @content('key'). "Excluir" um deles deixa o valor
 *   vazio — o elemento some do site, mas pode ser restaurado depois.
 * - Textos inseridos pelo painel (custom = true) aparecem no fim da seção
 *   (group) em que foram criados, via @extraTexts('pagina.grupo').
 */
class SiteText extends Model
{
    protected $fillable = [
        'page',
        'group',
        'group_label',
        'key',
        'label',
        'value',
        'long',
        'custom',
        'sort_order',
    ];

    protected $casts = [
        'long' => 'boolean',
        'custom' => 'boolean',
    ];
}