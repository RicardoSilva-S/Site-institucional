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
 * A imagem fica no próprio banco: "image_data" (base64) e "image_mime".
 * "image" guarda só o nome original do arquivo (ou o caminho antigo em
 * public/uploads, para banners cadastrados antes dessa mudança).
 */
class Banner extends Model
{
    /**
     * Colunas usadas nas listagens. Deixa de fora "image_data" para não
     * carregar todas as imagens do banco a cada página aberta.
     */
    public const LIST_COLUMNS = [
        'id', 'page', 'slot', 'image', 'image_mime', 'title', 'subtitle',
        'link', 'sort_order', 'active', 'created_at', 'updated_at',
    ];
    protected $fillable = [
        'page',
        'slot',
        'image',
        'image_mime',
        'image_data',
        'title',
        'subtitle',
        'link',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $hidden = [
        'image_data',
    ];

    public function imageUrl(): string
    {
        // Imagem guardada no banco: servida pela rota /banners/{id}/imagem.
        // O "v" muda quando o banner é editado, para o navegador baixar a nova.
        if ($this->image_mime) {
            return route('banners.image', [
                'banner' => $this->id,
                'v' => optional($this->updated_at)->timestamp,
            ]);
        }
 
        // Banners antigos, com a imagem em public/uploads.
        return asset($this->image);
    }
}
