<?php

namespace App\Core;

/**
 * Sessao — wrapper de $_SESSION
 * Cuida de flash messages e token CSRF.
 */
class Sessao
{
    public function iniciar(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Flash: grava ou lê uma mensagem que some depois de lida.
     * flash('erro', 'Senha incorreta')  → grava
     * flash('erro')                     → lê e apaga
     */
    public function flash(string $chave, $valor = null)
    {
        if ($valor !== null) {
            $_SESSION['_flash'][$chave] = $valor;
            return null;
        }

        $msg = $_SESSION['_flash'][$chave] ?? null;
        unset($_SESSION['_flash'][$chave]);
        return $msg;
    }

    /** Gera (ou retorna existente) token CSRF */
    public function csrfToken(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    /** Valida token CSRF enviado pelo formulário */
    public function validarCsrf(string $token): bool
    {
        return hash_equals($_SESSION['_csrf'] ?? '', $token);
    }

    public function set(string $chave, $valor): void
    {
        $_SESSION[$chave] = $valor;
    }

    public function get(string $chave, $padrao = null)
    {
        return $_SESSION[$chave] ?? $padrao;
    }

    public function remover(string $chave): void
    {
        unset($_SESSION[$chave]);
    }

    public function destruir(): void
    {
        session_destroy();
    }
}
