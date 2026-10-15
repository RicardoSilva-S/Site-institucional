<?php

// usuario administrador criado pelo AdminUserSeeder.
// lido por config() e nao por env() direto, para funcionar com "php artisan config:cache"
return [
    'name' => env('ADMIN_NAME', 'Administrador IDTNPR'),
    'email' => env('ADMIN_EMAIL', 'admin@idtnpr.org.br'),
    'password' => env('ADMIN_PASSWORD'),
];
