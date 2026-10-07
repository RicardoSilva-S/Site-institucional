<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Banner do site, gerenciado em /adm/banners.
 *
 * "page" guarda o nome da rota da página (home, institucional, ...).
 * Nulo = o banner aparece em todas as páginas.
 * "slot" é a posição dentro da página: nulo = carrossel do topo; o id de um
 * grupo do config/site_content.php = imagem ao lado dessa seção
 * (ver App\Support\BannerSlots).
 * "image" é o caminho relativo a public/ (ex: uploads/banners/abc.jpg).
 */
class Banner extends Model
{
    protected $fillable = [
        'page',
        'slot',
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
