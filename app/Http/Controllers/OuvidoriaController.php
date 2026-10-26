<?php

namespace App\Http\Controllers;

use App\Models\ManifestacaoOuvidoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Recebe o formulario da Ouvidoria (pagina Contato) e devolve o protocolo.
 */
class OuvidoriaController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $anonimo = $request->boolean('anonimo');

        $dados = $request->validate([
            'tipo' => ['required', Rule::in(array_keys(ManifestacaoOuvidoria::TIPOS))],
            'nome' => [$anonimo ? 'nullable' : 'required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'not_regex:/[\r\n]/', 'max:190'],
            'telefone' => ['nullable', 'string', 'max:30'],
            'mensagem' => ['required', 'string', 'max:5000'],
        ], [], [
            'tipo' => 'tipo de manifestação',
        ]);

        // anonimo: nao guarda nada que identifique a pessoa
        if ($anonimo) {
            $dados['nome'] = null;
            $dados['email'] = null;
            $dados['telefone'] = null;
        }

        $dados['anonimo'] = $anonimo;
        $manifestacao = ManifestacaoOuvidoria::create($dados);

        return redirect()
            ->to(route('contato') . '#ouvidoria')
            ->with('ouvidoria_protocolo', $manifestacao->protocolo());
    }
}
