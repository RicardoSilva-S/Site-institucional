<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarcoInstitucional;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Marcos da linha do tempo da página Institucional (/adm/marcos).
 */
class MarcoInstitucionalController extends Controller
{
    public function index(): View
    {
        return view('admin.marcos.index', [
            'marcos' => MarcoInstitucional::naOrdem(),
        ]);
    }

    public function create(): View
    {
        return $this->formulario(new MarcoInstitucional([
            'ordem' => (int) MarcoInstitucional::max('ordem') + 1,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        MarcoInstitucional::create($this->validados($request));

        return $this->voltarParaLista('Marco adicionado.');
    }

    public function edit(MarcoInstitucional $marco): View
    {
        return $this->formulario($marco);
    }

    public function update(Request $request, MarcoInstitucional $marco): RedirectResponse
    {
        $marco->update($this->validados($request));

        return $this->voltarParaLista('Marco atualizado.');
    }

    public function destroy(MarcoInstitucional $marco): RedirectResponse
    {
        $marco->delete();

        return $this->voltarParaLista('Marco removido.');
    }

    private function formulario(MarcoInstitucional $marco): View
    {
        return view('admin.marcos.form', ['marco' => $marco]);
    }

    private function validados(Request $request): array
    {
        $dados = $request->validate([
            'data' => ['required', 'string', 'max:40'],
            'texto' => ['required', 'string', 'max:500'],
            'ordem' => ['nullable', 'integer', 'min:0'],
        ], [
            'data.required' => 'Informe a data do marco.',
            'data.max' => 'A data pode ter no máximo 40 caracteres.',
            'texto.required' => 'Informe o texto do marco.',
            'texto.max' => 'O texto pode ter no máximo 500 caracteres.',
        ]);

        $dados['ordem'] = (int) ($dados['ordem'] ?? 0);

        return $dados;
    }

    private function voltarParaLista(string $mensagem): RedirectResponse
    {
        return redirect()->route('admin.marcos.index')->with('status', $mensagem);
    }
}