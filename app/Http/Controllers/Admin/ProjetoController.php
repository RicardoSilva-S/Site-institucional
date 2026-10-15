<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projeto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Projetos e soluções da página /projetos (/adm/projetos).
 * Cada projeto é um cartão do portfólio.
 */
class ProjetoController extends Controller
{
    public function index(): View
    {
        return view('admin.projetos.index', [
            'projetos' => Projeto::emOrdem(),
        ]);
    }

    public function create(): View
    {
        return $this->formulario(new Projeto([
            'estagio' => 'desenvolvimento',
            'link_rotulo' => 'Conhecer o projeto',
            'link_destino' => 'contato',
            'ordem' => (int) Projeto::max('ordem') + 1,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        Projeto::create($this->validados($request));

        return $this->voltarParaLista('Projeto adicionado.');
    }

    public function edit(Projeto $projeto): View
    {
        return $this->formulario($projeto);
    }

    public function update(Request $request, Projeto $projeto): RedirectResponse
    {
        $projeto->update($this->validados($request));

        return $this->voltarParaLista('Projeto atualizado.');
    }

    public function destroy(Projeto $projeto): RedirectResponse
    {
        $projeto->delete();

        return $this->voltarParaLista('Projeto excluído.');
    }

    private function formulario(Projeto $projeto): View
    {
        return view('admin.projetos.form', [
            'projeto' => $projeto,
            'estagios' => Projeto::ESTAGIOS,
            'destinos' => Projeto::DESTINOS,
        ]);
    }

    private function validados(Request $request): array
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'categorias' => ['nullable', 'string', 'max:255'],
            'estagio' => ['required', Rule::in(array_keys(Projeto::ESTAGIOS))],
            'breve_descricao' => ['required', 'string', 'max:500'],
            'tecnologia' => ['nullable', 'string', 'max:500'],
            'link_rotulo' => ['nullable', 'string', 'max:255'],
            'link_destino' => ['required', Rule::in(array_keys(Projeto::DESTINOS))],
            'ordem' => ['nullable', 'integer', 'min:0'],
        ], [
            'titulo.required' => 'Informe o nome do projeto.',
            'breve_descricao.required' => 'Escreva a descrição do projeto.',
        ]);

        $dados['ordem'] = (int) ($dados['ordem'] ?? 0);

        return $dados;
    }

    private function voltarParaLista(string $mensagem): RedirectResponse
    {
        return redirect()->route('admin.projetos.index')->with('status', $mensagem);
    }
}
