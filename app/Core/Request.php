<?php

namespace App\Core;

/**
 * Request — encapsula $_GET, $_POST e $_FILES
 * Evita acessar superglobais espalhadas pelo código.
 */
class Request
{
    private array $get;
    private array $post;
    private array $files;

    public function __construct()
    {
        $this->get   = $_GET   ?? [];
        $this->post  = $_POST  ?? [];
        $this->files = $_FILES ?? [];
    }

    /** Método HTTP da requisição (GET, POST, etc.) */
    public function method(): string
    {
        return strtoupper($_SERVER['METHOD'] ?? $_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    /** Dado do $_POST */
    public function input(string $chave, $padrao = null)
    {
        return $this->post[$chave] ?? $padrao;
    }

    /** Dado do $_GET */
    public function query(string $chave, $padrao = null)
    {
        return $this->get[$chave] ?? $padrao;
    }

    /** Arquivo do $_FILES */
    public function file(string $chave): ?array
    {
        return $this->files[$chave] ?? null;
    }

    /** URI atual sem query string */
    public function uri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $pos = strpos($uri, '?');
        return $pos !== false ? substr($uri, 0, $pos) : $uri;
    }
}
