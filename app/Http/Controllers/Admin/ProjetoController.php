<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projeto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            'icone' => 'padrao',
            'link_rotulo' => 'Solicitar reunião técnica',
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
        $projeto->update($this->validados($request, $projeto));

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
            'icones' => Projeto::ICONES,
            'destinos' => Projeto::DESTINOS,
        ]);
    }

    private function validados(Request $request, ?Projeto $projeto = null): array
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:120', 'alpha_dash', Rule::unique('projetos', 'slug')->ignore($projeto)],
            'icone' => ['nullable', Rule::in(array_keys(Projeto::ICONES))],
            'problema' => ['nullable', 'string', 'max:5000'],
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
            'slug.alpha_dash' => 'O endereço só pode ter letras, números, hífen e sublinhado.',
            'slug.unique' => 'Já existe outro projeto com este endereço.',
        ]);

        // Endereço em branco: o model gera um a partir do título.
        $dados['slug'] = filled($dados['slug'] ?? null) ? Str::slug($dados['slug']) : null;

        $dados['ordem'] = (int) ($dados['ordem'] ?? 0);

        return $dados;
    }

    private function voltarParaLista(string $mensagem): RedirectResponse
    {
        return redirect()->route('admin.projetos.index')->with('status', $mensagem);
    }
}
