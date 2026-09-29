<?php

namespace App\Support;

// o laravel 8 nao tem a diretiva @vite, entao ela e feita aqui
// le o public/hot (npm run dev) ou o manifest do build (npm run build)
class Vite
{
    public static function tags($entradas)
    {
        $entradas = (array) $entradas;
        $hot = public_path('hot');

        if (is_file($hot)) {
            $url = rtrim(trim(file_get_contents($hot)), '/');
            $tags = '<script type="module" src="' . $url . '/@vite/client"></script>';

            foreach ($entradas as $entrada) {
                $tags .= self::tag($url . '/' . $entrada);
            }

            return $tags;
        }

        $manifest = self::manifest();
        $tags = '';

        foreach ($entradas as $entrada) {
            if (!isset($manifest[$entrada])) {
                throw new \Exception("Arquivo {$entrada} nao encontrado no manifest do Vite. Rode npm run build.");
            }

            $chunk = $manifest[$entrada];

            foreach ($chunk['css'] ?? [] as $css) {
                $tags .= self::tag(asset('build/' . $css));
            }

            $tags .= self::tag(asset('build/' . $chunk['file']));
        }

        return $tags;
    }

    private static function manifest()
    {
        foreach (['build/manifest.json', 'build/.vite/manifest.json'] as $caminho) {
            if (is_file(public_path($caminho))) {
                return json_decode(file_get_contents(public_path($caminho)), true);
            }
        }

        throw new \Exception('Manifest do Vite nao encontrado. Rode npm run build ou npm run dev.');
    }

    private static function tag($url)
    {
        if (preg_match('/\.(css|scss|sass|less)$/', $url)) {
            return '<link rel="stylesheet" href="' . $url . '">';
        }

        return '<script type="module" src="' . $url . '"></script>';
    }
}
