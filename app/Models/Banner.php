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
 * * "device": no carrossel do topo, "desktop" (computador) ou "mobile" (celular);
 * "width" / "height" guardam o tamanho da imagem, usado como proporção no site.
 * "title" é só um nome interno (aparece no painel); o texto escrito sobre a
 * imagem no site é "display_title".
 * A imagem fica no próprio banco: "image_data" (base64) e "image_mime".
 * "image" guarda só o nome original do arquivo (ou o caminho antigo em
 * public/uploads, para banners cadastrados antes dessa mudança).
 */
class Banner extends Model
{
    public const DEVICE_DESKTOP = 'desktop';
    public const DEVICE_MOBILE = 'mobile';
 
    /** Tamanho padrão (largura, altura) de cada versão do banner do topo. */
    public const DEFAULT_SIZES = [
        self::DEVICE_DESKTOP => [1920, 700],
        self::DEVICE_MOBILE => [600, 700],
    ];
    /**
     * Colunas usadas nas listagens. Deixa de fora "image_data" para não
     * carregar todas as imagens do banco a cada página aberta.
     */
    public const LIST_COLUMNS = [
        'id', 'page', 'slot', 'device', 'width', 'height', 'image', 'image_mime',
        'title', 'display_title', 'subtitle', 'link', 'sort_order', 'active',
        'created_at', 'updated_at',
    ];
    protected $fillable = [
        'page',
        'slot',
        'image',
        'image_mime',
        'image_data',
        'device',
        'width',
        'height',
        'title',
        'display_title',
        'subtitle',
        'link',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'width' => 'integer',
        'height' => 'integer',
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
    public function isMobile(): bool
    {
        return $this->device === self::DEVICE_MOBILE;
    }
 
    /** Proporção para o CSS (ex: "1920 / 700"), ou null se não tiver tamanho. */
    public function ratio(): ?string
    {
        return $this->width && $this->height ? $this->width.' / '.$this->height : null;
    }
}
