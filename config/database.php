<?php

/**
 * Configuração do banco de dados
 * Os valores reais ficam no .env — nunca commitar senhas no git
 */

return [
    'host'    => getenv('DB_HOST')     ?: 'localhost',
    'dbname'  => getenv('DB_DATABASE') ?: 'site_institucional',
    'user'    => getenv('DB_USER')     ?: 'root',
    'pass'    => getenv('DB_PASS')     ?: '',
    'charset' => 'utf8mb4',
];
