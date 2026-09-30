# Site institucional IDTNPR

Aplicação Laravel que serve o site público do IDTNPR e um painel de
edição de textos autenticado.

## Como rodar localmente

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # se estiver usando sqlite (padrão do .env.example)
php artisan migrate
php artisan db:seed              # cria o usuário do painel (ver ADMIN_* no .env)
php artisan serve
```

Acesse `http://localhost:8000` para o site e `http://localhost:8000/login`
para entrar no painel, com o e-mail/senha definidos em `ADMIN_EMAIL` e
`ADMIN_PASSWORD` no `.env` (troque `ADMIN_PASSWORD` antes de publicar em
produção — o valor padrão é só para desenvolvimento).

## Estrutura

- `resources/views/layouts/app.blade.php` — layout público (header, nav, footer), compartilhado por todas as páginas do site.
- `resources/views/site/*.blade.php` — uma view por página pública (`home.blade.php`, `marco-legal.blade.php`, …).
- `config/site_content.php` — todos os textos editáveis do site, com rótulo, agrupamento e valor padrão de cada campo. É a referência para o painel montar o formulário.
- `app/Support/SiteContent.php` — resolve o texto a exibir: o que foi salvo no banco (tabela `site_content_values`) ou o `default` do `config/site_content.php`.
- A diretiva Blade `@content('home.hero.title')` imprime esse texto em qualquer view (ver `App\Providers\AppServiceProvider`).
- `resources/views/admin/content-edit.blade.php` + `app/Http/Controllers/Admin/ContentController.php` — o painel `/admin/conteudo` (autenticação via `App\Http\Controllers\Auth\LoginController`, usuário criado por `database/seeders/AdminUserSeeder.php`).
- `public/css`, `public/js`, `public/assets` — CSS, JS e imagens estáticas do site (servidos diretamente pelo Laravel).

## Como adicionar uma nova página

1. Crie `resources/views/site/nome-da-pagina.blade.php` com `@extends('layouts.app')`, seguindo o padrão de `home.blade.php` ou `marco-legal.blade.php`.
2. Em `config/site_content.php`, adicione um novo item com `'page' => 'nome-da-pagina'` e os campos de texto dessa página (prefixados com `nome-da-pagina.`).
3. Na view, use `@content('nome-da-pagina.secao.campo')` para cada texto editável.
4. Registre a rota em `routes/web.php`, apontando para um método em `App\Http\Controllers\SiteController` (ou um controller novo).
5. Pronto — o painel `/admin/conteudo` mostra a nova página automaticamente, sem precisar mexer nele.

## Como o painel de edição de textos funciona

O painel (`/admin/conteudo`, atrás de login) lista todos os campos de
`config/site_content.php`, agrupados por página e seção. Ao salvar, os
valores vão para a tabela `site_content_values` (uma linha por texto
alterado) e ficam em cache — visíveis para **qualquer** visitante do
site, não só no navegador de quem editou. "Restaurar padrão" apaga os
overrides salvos e volta ao texto original do `config/site_content.php`.
Há também um botão de exportar os textos atuais em `.json`.

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
