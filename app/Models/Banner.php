<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Banner do topo do site, gerenciado em /adm/banners.
 *
 * "page" guarda o nome da rota da página (home, institucional, ...).
 * Nulo = o banner aparece em todas as páginas.
 * "image" é o caminho relativo a public/ (ex: uploads/banners/abc.jpg).
 */
class Banner extends Model
{
    protected $fillable = [
        'page',
        'image',
        'title',
        'subtitle',
        'link',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function imageUrl(): string
    {
        return asset($this->image);
    }
}