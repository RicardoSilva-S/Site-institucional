<?php

namespace App\Controllers;

class PainelController extends Controller
{
    public function index(): void
    {
        $this->view('admin/dashboard', [
            'titulo' => 'Painel Administrativo',
            'usuario' => $this->sessao->get('usuario_nome'),
        ]);
    }
}