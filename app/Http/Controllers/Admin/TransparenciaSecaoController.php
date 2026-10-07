<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransparenciaSecao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Portal da Transparência no painel (/adm/transparencia).
 *
 * A tela principal (index) lista as seções com os documentos de cada uma.
 * Aqui ficam a lista e o cadastro das seções; os documentos ficam no
 * TransparenciaDocumentoController.
 */
class TransparenciaSecaoController extends Controller
{
    public function index(): View
    {
        return view('admin.transparencia.index', [
            'secoes' => TransparenciaSecao::comDocumentos(),
        ]);
    }

    public function create(): View
    {
        $proximaOrdem = (int) TransparenciaSecao::max('ordem') + 1;

        return view('admin.transparencia.secao-form', [
            'secao' => new TransparenciaSecao(['ordem' => $proximaOrdem]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validados($request);
        $dados['slug'] = $this->slugUnico($dados['titulo']);

        TransparenciaSecao::create($dados);

        return redirect()->route('admin.transparencia.index')->with('status', 'Seção adicionada.');
    }

    public function edit(TransparenciaSecao $secao): View
    {
        return view('admin.transparencia.secao-form', ['secao' => $secao]);
    }

    public function update(Request $request, TransparenciaSecao $secao): RedirectResponse
    {
        $dados = $this->validados($request);

        if ($dados['titulo'] !== $secao->titulo) {
            $dados['slug'] = $this->slugUnico($dados['titulo'], $secao->id);
        }

        $secao->update($dados);

        return redirect()->route('admin.transparencia.index')->with('status', 'Seção atualizada.');
    }

    public function destroy(TransparenciaSecao $secao): RedirectResponse
    {
        // Os documentos da seção são apagados junto (cascata na chave estrangeira).
        $secao->delete();

        return redirect()->route('admin.transparencia.index')->with('status', 'Seção excluída, com os documentos dela.');
    }

    private function validados(Request $request): array
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'subtitulo' => ['nullable', 'string', 'max:255'],
            'ordem' => ['nullable', 'integer', 'min:0'],
        ], [
            'titulo.required' => 'Informe o título da seção.',
        ]);

        $dados['ordem'] = (int) ($dados['ordem'] ?? 0);

        return $dados;
    }

    /**
     * Apelido da seção usado no site (filtros e âncora, ex: #prestacao-de-contas).
     * Se já existir, acrescenta um número: prestacao-de-contas-2.
     */
    private function slugUnico(string $titulo, ?int $ignorarId = null): string
    {
        $base = Str::slug($titulo) ?: 'secao';
        $slug = $base;
        $n = 2;

        while (TransparenciaSecao::where('slug', $slug)
            ->when($ignorarId, function ($query) use ($ignorarId) {
                $query->where('id', '!=', $ignorarId);
            })
            ->exists()) {
            $slug = $base . '-' . $n++;
        }

        return $slug;
    }
}
