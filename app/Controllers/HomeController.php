<?php

namespace App\Controllers;

/**
 * HomeController — página inicial do site
 */
class HomeController extends Controller
{
    public function index(): void
    {
        // Futuramente: buscar banners, noticias recentes, etc. via Model
        $this->view('home', [
            'titulo' => 'Bem-vindo',
        ]);
    }
}
