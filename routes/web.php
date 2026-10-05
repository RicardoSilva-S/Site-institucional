<?php
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\MembroInstitucionalController;
use App\Http\Controllers\Admin\TransparenciaDocumentoController;
use App\Http\Controllers\Admin\TransparenciaSecaoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// Site público -----------------------------------------------------------
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/institucional', [SiteController::class, 'institucional'])->name('institucional');
Route::get('/marco-legal', [SiteController::class, 'marcoLegal'])->name('marco-legal');
Route::get('/atuacao', [SiteController::class, 'atuacao'])->name('atuacao');
Route::get('/projetos', [SiteController::class, 'projetos'])->name('projetos');
Route::get('/editais', [SiteController::class, 'editais'])->name('editais');
Route::get('/contato', [SiteController::class, 'contato'])->name('contato');
Route::post('/contato/enviar', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contato.enviar');
Route::get('/transparencia', [SiteController::class, 'transparencia'])->name('transparencia');
Route::get('/politica-de-privacidade', [SiteController::class, 'privacidade'])->name('privacidade');

// PDF dos documentos da transparência (fica guardado no banco, ver SiteController)
Route::get('/transparencia/documentos/{documento}/pdf', [SiteController::class, 'documentoTransparencia'])
    ->name('transparencia.documento');

// Foto da diretoria/conselho (fica guardada no banco, ver SiteController)
Route::get('/equipe/{membro}/foto', [SiteController::class, 'fotoMembro'])->name('equipe.foto');

// Imagem dos banners (fica guardada no banco, ver BannerController::image)
Route::get('/banners/{banner}/imagem', [BannerController::class, 'image'])->name('banners.image');

// Painel administrativo --------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login-adm', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login-adm', [LoginController::class, 'login'])
        ->middleware('throttle:20,1')
        ->name('login.attempt');
});

Route::middleware(['auth', 'ativo'])->prefix('adm')->name('admin.')->group(function () {
    Route::post('/sair', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', fn () => redirect()->route('admin.pages.show', 'home'))->name('dashboard');

    Route::get('/paginas/{page}', [ContentController::class, 'show'])->name('pages.show');
    Route::put('/paginas/{page}', [ContentController::class, 'update'])->name('pages.update');
    Route::post('/paginas/{page}/textos', [ContentController::class, 'store'])->name('texts.store');
    Route::delete('/textos/{text}', [ContentController::class, 'destroy'])->name('texts.destroy');
    Route::post('/textos/{text}/restaurar', [ContentController::class, 'restore'])->name('texts.restore');

    Route::resource('banners', BannerController::class)->except('show');

    Route::get('/transparencia', [TransparenciaSecaoController::class, 'index'])->name('transparencia.index');
    Route::resource('transparencia/secoes', TransparenciaSecaoController::class)
        ->except(['index', 'show'])
        ->parameters(['secoes' => 'secao'])
        ->names('transparencia.secoes');
    Route::resource('transparencia/documentos', TransparenciaDocumentoController::class)
        ->except(['index', 'show'])
        ->parameters(['documentos' => 'documento'])
        ->names('transparencia.documentos');

    // Diretoria e conselho da página Institucional (foto guardada no banco)
    Route::resource('equipe', MembroInstitucionalController::class)
        ->except('show')
        ->parameters(['equipe' => 'membro']);

    Route::resource('usuarios', UserController::class)
        ->only(['index', 'create', 'store', 'edit', 'update'])
        ->middleware('admin');

    // Mensagens do formulario de contato
    Route::get('/mensagens', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::post('/mensagens/{message}/lida', [ContactMessageController::class, 'toggleRead'])->name('messages.toggle-read');
});
