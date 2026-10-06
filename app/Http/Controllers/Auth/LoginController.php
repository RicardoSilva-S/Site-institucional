<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Login simples por e-mail/senha para o painel /admin/conteudo.
 * O usuário admin é criado pelo seeder (database/seeders/AdminUserSeeder.php).
 *
 * Contra tentativa e erro de senha: depois de MAX_TENTATIVAS erros seguidos
 * para o mesmo e-mail + IP, o login fica bloqueado por BLOQUEIO_SEGUNDOS.
 */
class LoginController extends Controller
{
    private const MAX_TENTATIVAS = 5;
    private const BLOQUEIO_SEGUNDOS = 60;

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $chave = $this->chaveDeTentativas($request);

        if (RateLimiter::tooManyAttempts($chave, self::MAX_TENTATIVAS)) {
            $segundos = RateLimiter::availableIn($chave);

            return back()
                ->withErrors(['email' => "Muitas tentativas de login. Tente novamente em {$segundos} segundos."])
                ->onlyInput('email');
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($chave, self::BLOQUEIO_SEGUNDOS);

            return back()
                ->withErrors(['email' => 'E-mail ou senha incorretos.'])
                ->onlyInput('email');
        }

        RateLimiter::clear($chave);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.content.edit'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function chaveDeTentativas(Request $request): string
    {
        return 'login|' . Str::lower($request->input('email')) . '|' . $request->ip();
    }
}
