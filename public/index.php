<?php

declare(strict_types=1);

/**
 * Front Controller — tudo passa por aqui
 * 1. Autoload
 * 2. Carrega variáveis de ambiente (.env)
 * 3. Instancia Request e Router
 * 4. Carrega as rotas
 * 5. Despacha
 */

define('ROOT', dirname(__DIR__));

// 1. Autoload PSR-4
require ROOT . '/app/Core/Autoload.php';

// 2. Carrega .env se existir
$envFile = ROOT . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
        if (strpos(trim($linha), '#') === 0) continue; // ignora comentários
        if (strpos($linha, '=') === false) continue;
        [$chave, $valor] = explode('=', $linha, 2);
        putenv(trim($chave) . '=' . trim($valor));
    }
}

// 3. Request e Router
$request = new App\Core\Request();
$router  = new App\Core\Router($request);

// 4. Rotas
require ROOT . '/routes/web.php';

// 5. Despacha
$router->dispatch();
