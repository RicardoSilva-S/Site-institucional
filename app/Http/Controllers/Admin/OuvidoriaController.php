<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManifestacaoOuvidoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Manifestacoes da ouvidoria no painel (/adm/ouvidoria).
 */
class OuvidoriaController extends Controller
{
    public function index(): View
    {
        return view('admin.ouvidoria', [
            'manifestacoes' => ManifestacaoOuvidoria::query()->orderByDesc('created_at')->simplePaginate(20),
            'pendentes' => ManifestacaoOuvidoria::query()->where('status', ManifestacaoOuvidoria::STATUS_RECEBIDA)->count(),
        ]);
    }

    public function alternarStatus(ManifestacaoOuvidoria $manifestacao): RedirectResponse
    {
        $manifestacao->alternarStatus();

        return back();
    }
}
