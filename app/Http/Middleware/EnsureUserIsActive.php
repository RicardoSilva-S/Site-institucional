<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Usuario desativado no painel nao entra mais: se estiver logado,
 * e deslogado na proxima pagina que abrir.
 */
class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && ! $request->user()->ativo) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => 'Este usuário está desativado.']);
        }

        return $next($request);
    }
}
