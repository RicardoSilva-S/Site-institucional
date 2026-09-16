<?php

/**
 * Autoload PSR-4 simples
 * Mapeia namespace App\ para a pasta app/
 */
spl_autoload_register(function (string $class): void {
    // App\Core\Database → app/Core/Database.php
    if (strpos($class, 'App\\') === 0) {
        $caminho = __DIR__ . '/../../' .
            str_replace(['App\\', '\\'], ['app/', '/'], $class) . '.php';

        if (file_exists($caminho)) {
            require_once $caminho;
        }
    }
});
