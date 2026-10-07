<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Libera a rota so para quem tem papel de administrador.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user() && $request->user()->ehAdmin(), 403);

        return $next($request);
    }
}
