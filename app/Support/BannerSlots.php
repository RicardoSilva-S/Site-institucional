<?php

namespace App\Support;

use App\Models\Banner;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

/**
 * Posições de banner do site: o carrossel do topo de cada página e as
 * imagens ao lado das seções ("banners de seção").
 *
 * Um grupo do config/site_content.php vira uma posição quando tem a chave
 * "banner", com o caminho da imagem padrão (relativo a public/):
 *
 *   ['id' => 'governanca', 'label' => '...', 'banner' => 'assets/atuacao/governanca.svg', ...]
 *
 * Na view: @include('partials.section-banner', ['slot' => 'governanca']).
 * Enquanto a posição não tiver banner ativo em /adm/banners, o site mostra a
 * imagem padrão — a seção nunca fica com o espaço vazio.
 *
 * No banco (tabela banners): page = nome da rota, slot = id do grupo.
 * slot nulo = carrossel do topo.
 */
class BannerSlots
{
    /** Separa página e seção no campo "posicao" do formulário: "atuacao:governanca". */
    public const SEPARATOR = ':';

    /**
     * Páginas com rota e as posições de seção de cada uma.
     *
     * @return array<string, array{label: string, page: string, slots: array<string, array{label: string, default: string}>}>
     */
    public static function pages(): array
    {
        $pages = [];

        foreach (SiteContent::schema() as $page) {
            if (empty($page['route'])) {
                continue;
            }

            $slots = [];
            foreach ($page['groups'] as $group) {
                if (! empty($group['banner'])) {
                    $slots[$group['id']] = ['label' => $group['label'], 'default' => $group['banner']];
                }
            }

            $pages[$page['route']] = [
                'label' => $page['pageLabel'],
                'page' => $page['page'],
                'slots' => $slots,
            ];
        }

        return $pages;
    }

    /** Imagem padrão de uma posição de seção (relativa a public/), ou null. */
    public static function fallback(string $route, string $slot): ?string
    {
        return static::pages()[$route]['slots'][$slot]['default'] ?? null;
    }

    /** Ex: "Atuação · Frente 01 — Governança e modernização". */
    public static function label(?string $route, ?string $slot): string
    {
        $pages = static::pages();
        $page = $route === null ? 'Todas as páginas' : ($pages[$route]['label'] ?? $route);

        if ($slot === null) {
            return $page.' · Carrossel do topo';
        }

        return $page.' · '.($pages[$route]['slots'][$slot]['label'] ?? $slot);
    }

    /**
     * Opções do campo "Onde aparece" do formulário de banner.
     *
     * @return array<string, array<string, string>> [página => [valor => rótulo]]
     */
    public static function options(): array
    {
        $options = ['Todas as páginas' => ['' => 'Carrossel do topo']];

        foreach (static::pages() as $route => $page) {
            $options[$page['label']] = [$route => 'Carrossel do topo'];

            foreach ($page['slots'] as $slot => $info) {
                $options[$page['label']][static::encode($route, $slot)] = 'Ao lado da seção "'.$info['label'].'"';
            }
        }

        return $options;
    }

    /** [rota, seção] -> valor do campo "posicao" ("", "atuacao" ou "atuacao:governanca"). */
    public static function encode(?string $route, ?string $slot): string
    {
        return $slot === null ? (string) $route : $route.self::SEPARATOR.$slot;
    }

    /** @return array{0: ?string, 1: ?string} [rota, seção] */
    public static function decode(?string $value): array
    {
        $parts = explode(self::SEPARATOR, (string) $value, 2);

        return [
            $parts[0] !== '' ? $parts[0] : null,
            isset($parts[1]) && $parts[1] !== '' ? $parts[1] : null,
        ];
    }

    /**
     * Banners ativos de uma posição de seção, na ordem do painel. Faz uma
     * consulta só por página (guardada na requisição atual).
     */
    public static function active(string $route, string $slot): Collection
    {
        $request = request();
        $key = 'banner-slots.'.$route;

        if (! $request->attributes->has($key)) {
            $banners = Schema::hasTable('banners')
                ? Banner::query()
                    ->where('page', $route)
                    ->whereNotNull('slot')
                    ->where('active', true)
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
                    ->groupBy('slot')
                : collect();

            $request->attributes->set($key, $banners);
        }

        return $request->attributes->get($key)->get($slot, collect());
    }
}
