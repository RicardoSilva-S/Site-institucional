<?php

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\PainelController;

/**
 * Rotas públicas do site
 * $router já está disponível — injetado pelo index.php
 */

// Home
$router->get('/', [HomeController::class, 'index']);

// Login do painel
$router->get('/admin/login',  [LoginController::class, 'formulario']);
$router->post('/admin/login', [LoginController::class, 'entrar']);
$router->get('/admin/sair',   [LoginController::class, 'sair']);
$router->get('/admin', [PainelController::class, 'index']);
// TODO: demais rotas serão adicionadas conforme os controllers forem criados
// Exemplos:
// $router->get('/institucional',      [PaginaController::class, 'institucional']);
// $router->get('/noticias',           [NoticiaController::class, 'index']);
// $router->get('/noticias/{slug}',    [NoticiaController::class, 'detalhe']);
// $router->get('/contato',            [ContatoController::class, 'formulario']);
// $router->post('/contato',           [ContatoController::class, 'enviar']);
