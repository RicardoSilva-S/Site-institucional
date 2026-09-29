<?php

use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// Site público -----------------------------------------------------------
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/marco-legal', [SiteController::class, 'marcoLegal'])->name('marco-legal');

// Autenticação (painel administrativo) ------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Painel de edição de textos -----------------------------------------------
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/conteudo', [ContentController::class, 'edit'])->name('content.edit');
    Route::post('/conteudo', [ContentController::class, 'update'])->name('content.update');
    Route::post('/conteudo/restaurar', [ContentController::class, 'reset'])->name('content.reset');
    Route::get('/conteudo/exportar', [ContentController::class, 'export'])->name('content.export');
});
