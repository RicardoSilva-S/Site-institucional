<?php

namespace App\Controllers;

use App\Core\Sessao;
use App\Core\Request;

/**
 * LoginController — acesso ao painel administrativo
 */
class LoginController extends Controller
{
    public function formulario(): void
    {
        // Se já estiver logado, manda direto pro painel
        if ($this->sessao->get('usuario_id')) {
            $this->redirect('/Site-institucional/public/admin');
        }

        $this->view('admin/login', [
            'titulo' => 'Entrar no painel',
            'csrf'   => $this->sessao->csrfToken(),
            'erro'   => $this->sessao->flash('erro'),
        ]);
    }

    public function entrar(): void
    {
        $request = new Request();

        // Valida CSRF
        if (!$this->sessao->validarCsrf($request->input('_csrf', ''))) {
            $this->sessao->flash('erro', 'Requisição inválida. Tente novamente.');
            $this->redirect('/Site-institucional/public/admin/login');
        }

        $email = trim($request->input('email', ''));
        $senha = $request->input('senha', '');

        // TODO: integrar com Model\Usuario quando estiver pronto
        // Por ora, usuário fixo só para testar o fluxo
        $usuarioTeste = ['id' => 1, 'nome' => 'Admin', 'email' => 'admin@site.com', 'senha_hash' => password_hash('admin123', PASSWORD_BCRYPT)];

        if ($email === $usuarioTeste['email'] && password_verify($senha, $usuarioTeste['senha_hash'])) {
            $this->sessao->set('usuario_id',   $usuarioTeste['id']);
            $this->sessao->set('usuario_nome', $usuarioTeste['nome']);
            $this->redirect('/Site-institucional/public/admin');    
        }

        $this->sessao->flash('erro', 'E-mail ou senha incorretos.');
        $this->redirect('/Site-institucional/public/admin/login');
    }

    public function sair(): void
    {
        $this->sessao->remover('usuario_id');
        $this->sessao->remover('usuario_nome');
        $this->redirect('/admin/login');
    }
}
