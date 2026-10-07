<?php

namespace App\Support;

use App\Models\SiteText;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Fachada estática para os textos editáveis do site.
 *
 * - config/site_content.php define as páginas, seções (groups) e o texto
 *   ORIGINAL de cada campo.
 * - A tabela site_texts guarda o texto ATUAL de cada campo, mais os textos
 *   novos inseridos pelo painel /adm.
 *
 * Nas views:
 *   @content('home.hero.title')   -> texto atual do campo
 *   @extraTexts('home.hero')      -> textos inseridos pelo painel nessa seção
 *
 * Tudo fica em cache para não consultar o banco a cada @content(). O painel
 * chama forget() sempre que altera algo.
 */
class SiteContent
{
    protected const CACHE_KEY = 'site_texts_v1';

    protected static ?array $memo = null;

    protected static ?array $defaultsMemo = null;

    /** Estrutura completa (páginas > grupos > campos) do config. */
    public static function schema(): array
    {
        return config('site_content', []);
    }

    /** Uma página do schema pelo id ("home", "institucional"...), ou null. */
    public static function page(string $page): ?array
    {
        foreach (static::schema() as $item) {
            if ($item['page'] === $page) {
                return $item;
            }
        }

        return null;
    }

    /** @return array<string, string> mapa [key => texto original] */
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
     * Dados em cache: ['values' => [key => valor], 'extras' => ['pagina.grupo' => [textos]]]
     */
    protected static function data(): array
    {
        if (static::$memo !== null) {
            return static::$memo;
        }

        return static::$memo = Cache::rememberForever(static::CACHE_KEY, function () {
            if (! Schema::hasTable('site_texts')) {
                return ['values' => [], 'extras' => []];
            }

            $values = [];
            $extras = [];

            foreach (SiteText::query()->orderBy('sort_order')->get() as $text) {
                if ($text->custom) {
                    if ($text->value !== null && $text->value !== '') {
                        $extras["{$text->page}.{$text->group}"][] = $text->value;
                    }
                } else {
                    $values[$text->key] = (string) $text->value;
                }
            }

            return ['values' => $values, 'extras' => $extras];
        });
    }

    /**
     * Texto a exibir. Se o campo ainda não estiver no banco (ex: acabou de
     * ser adicionado no config), usa o texto original.
     */
    public static function text(string $key): string
    {
        $values = static::data()['values'];

        if (array_key_exists($key, $values)) {
            return $values[$key];
        }

        return static::defaults()[$key] ?? '';
    }

    /**
     * Texto do campo como frase independente: sem ":" ou pontuação no começo
     * e com inicial maiúscula. Usado quando o complemento de um item de lista
     * (": inventário de dados...") aparece sozinho, num cartão.
     */
    public static function sentence(string $key): string
    {
        return Str::ucfirst((string) preg_replace('/^[\s:;,.\-–—]+/u', '', static::text($key)));
    }

    /** O campo tem texto? (falso quando foi excluído pelo painel) */
    public static function has(string $key): bool
    {
        return trim(static::text($key)) !== '';
    }

    /** @return string[] textos inseridos pelo painel numa seção ("pagina.grupo") */
    public static function extras(string $pageGroup): array
    {
        return static::data()['extras'][$pageGroup] ?? [];
    }

    /**
     * Garante que todo campo do config exista na tabela site_texts.
     * Campos que já existem não são tocados (o valor editado é mantido).
     * Na primeira vez, aproveita os textos editados no painel antigo
     * (tabela site_content_values), se ela existir.
     */
    public static function sync(): void
    {
        if (! Schema::hasTable('site_texts')) {
            return;
        }

        $existing = SiteText::query()->pluck('key')->flip();

        $oldOverrides = Schema::hasTable('site_content_values')
            ? DB::table('site_content_values')->pluck('value', 'key')
            : collect();

        $now = now();
        $rows = [];

        foreach (static::schema() as $page) {
            $order = 0;
            foreach ($page['groups'] as $group) {
                foreach ($group['fields'] as $field) {
                    $order += 10;

                    if ($existing->has($field['key'])) {
                        continue;
                    }

                    $old = $oldOverrides[$field['key']] ?? null;

                    $rows[] = [
                        'page' => $page['page'],
                        'group' => $group['id'],
                        'group_label' => $group['label'],
                        'key' => $field['key'],
                        'label' => $field['label'],
                        'value' => ($old !== null && $old !== '') ? $old : $field['default'],
                        'long' => ! empty($field['long']),
                        'custom' => false,
                        'sort_order' => $order,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        // Lotes de 50: 50 linhas x 11 colunas fica abaixo do limite de 999
        // valores por comando do SQLite usado nos testes (PHP 7.4).
        foreach (array_chunk($rows, 50) as $chunk) {
            SiteText::query()->insert($chunk);
        }

        if ($rows) {
            static::forget();
        }
    }

    public static function forget(): void
    {
        Cache::forget(static::CACHE_KEY);
        static::$memo = null;
    }
}