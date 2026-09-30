<?php

namespace App\Support;

use App\Models\SiteContentValue;
use Illuminate\Support\Facades\Cache;

/**
 * Fachada estática para os textos editáveis do site.
 *
 * - schema(): a estrutura completa (páginas > grupos > campos), vinda de
 *   config/site_content.php. Usada pelo painel /admin/conteudo para montar
 *   o formulário (rótulos, agrupamento, campo longo ou curto).
 * - defaults(): mapa achatado [key => texto padrão], extraído do schema.
 * - text($key): o texto que deve aparecer no site — o override salvo no
 *   banco (tabela site_content_values), ou o default quando não há override.
 *
 * Os overrides ficam em cache (Cache::rememberForever) para não bater no
 * banco em toda chamada de @content() dentro de uma view. O painel chama
 * forget() sempre que salva ou restaura textos, invalidando o cache.
 */
class SiteContent
{
    protected const CACHE_KEY = 'site_content_overrides';

    protected static ?array $overridesMemo = null;

    protected static ?array $defaultsMemo = null;

    /**
     * @return array<int, array{page: string, pageLabel: string, groups: array}>
     */
    public static function schema(): array
    {
        return config('site_content', []);
    }

    /**
     * @return array<string, string> mapa [key => default]
     */
    public static function defaults(): array
    {
        if (static::$defaultsMemo !== null) {
            return static::$defaultsMemo;
        }

        $defaults = [];
        foreach (static::schema() as $page) {
            foreach ($page['groups'] as $group) {
                foreach ($group['fields'] as $field) {
                    $defaults[$field['key']] = $field['default'];
                }
            }
        }

        return static::$defaultsMemo = $defaults;
    }

    /**
     * @return array<string, string|null> mapa [key => valor salvo no banco]
     */
    protected static function overrides(): array
    {
        if (static::$overridesMemo !== null) {
            return static::$overridesMemo;
        }

        return static::$overridesMemo = Cache::rememberForever(
            static::CACHE_KEY,
            fn () => SiteContentValue::query()->pluck('value', 'key')->all(),
        );
    }

    /**
     * O texto a exibir para uma key: override salvo, ou o default do schema.
     */
    public static function text(string $key): string
    {
        $overrides = static::overrides();

        if (array_key_exists($key, $overrides) && $overrides[$key] !== null && $overrides[$key] !== '') {
            return $overrides[$key];
        }

        return static::defaults()[$key] ?? '';
    }

    /**
     * Salva um lote de overrides [key => valor]. Uma string vazia remove o
     * override (volta a usar o default) para manter o banco enxuto.
     */
    public static function save(array $values): void
    {
        foreach ($values as $key => $value) {
            if (! array_key_exists($key, static::defaults())) {
                // Ignora chaves que não existem no schema (formulário adulterado).
                continue;
            }

            if ($value === null || trim((string) $value) === '') {
                SiteContentValue::query()->where('key', $key)->delete();

                continue;
            }

            SiteContentValue::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        static::forget();
    }

    /**
     * Restaura todos os textos para o padrão (apaga todos os overrides).
     */
    public static function resetAll(): void
    {
        SiteContentValue::query()->delete();
        static::forget();
    }

    protected static function forget(): void
    {
        Cache::forget(static::CACHE_KEY);
        static::$overridesMemo = null;
    }
}
