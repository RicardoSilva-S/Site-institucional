<?php

namespace App\Controllers;

use App\Core\Sessao;

/**
 * Controller — classe base abstrata
 * Todos os Controllers herdam daqui.
 */
abstract class Controller
{
    protected Sessao $sessao;

    public function __construct()
    {
        $this->sessao = new Sessao();
        $this->sessao->iniciar();
    }

    /** Renderiza uma view passando dados */
    protected function view(string $template, array $dados = []): void
    {
        // Disponibiliza as variáveis para a view
        extract($dados);

        $arquivo = __DIR__ . '/../Views/' . $template . '.php';

        if (!file_exists($arquivo)) {
            die("View não encontrada: {$template}");
        }

        require $arquivo;
    }

    /** Redireciona para uma URL */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /** Grava mensagem flash na sessão */
    protected function flash(string $tipo, string $msg): void
    {
        $this->sessao->flash($tipo, $msg);
    }

    /** Aborta com 404 */
    protected function abort404(): void
    {
        http_response_code(404);
        require __DIR__ . '/../Views/404.php';
        exit;
    }
}
