<?php
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// Site público -----------------------------------------------------------
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/institucional', [SiteController::class, 'institucional'])->name('institucional');
Route::get('/marco-legal', [SiteController::class, 'marcoLegal'])->name('marco-legal');
Route::get('/atuacao', [SiteController::class, 'atuacao'])->name('atuacao');
Route::get('/contato', [SiteController::class, 'contato'])->name('contato');
Route::get('/transparencia', [SiteController::class, 'transparencia'])->name('transparencia');

// Painel administrativo --------------------------------------------------
// Separado do site: o site não tem nenhum link para cá. O acesso é só
// digitando o endereço /login-adm.
Route::middleware('guest')->group(function () {
    Route::get('/login-adm', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login-adm', [LoginController::class, 'login'])->name('login.attempt');
});

Route::middleware(['auth', 'ativo'])->prefix('adm')->name('admin.')->group(function () {
    Route::post('/sair', [LoginController::class, 'logout'])->name('logout');

 

    // /adm abre direto a primeira página do menu lateral (Início).

    Route::get('/', fn () => redirect()->route('admin.pages.show', 'home'))->name('dashboard');

 

    // Textos de cada página do site

    Route::get('/paginas/{page}', [ContentController::class, 'show'])->name('pages.show');

    Route::put('/paginas/{page}', [ContentController::class, 'update'])->name('pages.update');

    Route::post('/paginas/{page}/textos', [ContentController::class, 'store'])->name('texts.store');

    Route::delete('/textos/{text}', [ContentController::class, 'destroy'])->name('texts.destroy');

    Route::post('/textos/{text}/restaurar', [ContentController::class, 'restore'])->name('texts.restore');

    // Banners do topo do site
    Route::resource('banners', BannerController::class)->except('show');

    // Usuarios do painel (so administrador)
    Route::resource('usuarios', UserController::class)
        ->only(['index', 'create', 'store', 'edit', 'update'])
        ->middleware('admin');
});