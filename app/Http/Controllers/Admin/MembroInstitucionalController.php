<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembroInstitucional;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Diretoria e conselho da página Institucional (/adm/equipe).
 *
 * A foto é guardada dentro do banco (foto_data, foto_mime, foto_nome), igual
 * às imagens dos banners: no Render gratuito o disco do servidor é apagado a
 * cada reinício, então uma foto salva em pasta sumiria.
 */
class MembroInstitucionalController extends Controller
{
    public function index(): View
    {
        return view('admin.equipe.index', [
            'grupos' => collect(MembroInstitucional::GRUPOS)->map(function ($rotulo, $grupo) {
                return [
                    'rotulo' => $rotulo,
                    'membros' => MembroInstitucional::doGrupo($grupo),
                ];
            }),
        ]);
    }

    public function create(Request $request): View
    {
        $grupo = array_key_exists($request->query('grupo'), MembroInstitucional::GRUPOS)
            ? $request->query('grupo')
            : 'diretoria';

        return $this->formulario(new MembroInstitucional([
            'grupo' => $grupo,
            'ordem' => (int) MembroInstitucional::where('grupo', $grupo)->max('ordem') + 1,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validados($request);

        if ($request->hasFile('foto')) {
            $dados = array_merge($dados, $this->camposDaFoto($request->file('foto')));
        }

        MembroInstitucional::create($dados);

        return $this->voltarParaLista('Pessoa adicionada.');
    }

    public function edit(MembroInstitucional $membro): View
    {
        return $this->formulario($membro);
    }

    public function update(Request $request, MembroInstitucional $membro): RedirectResponse
    {
        $dados = $this->validados($request);

        if ($request->hasFile('foto')) {
            $dados = array_merge($dados, $this->camposDaFoto($request->file('foto')));
        } elseif ($request->boolean('remover_foto')) {
            $dados['foto_nome'] = null;
            $dados['foto_mime'] = null;
            $dados['foto_data'] = null;
        }

        $membro->update($dados);

        return $this->voltarParaLista('Dados atualizados.');
    }

    public function destroy(MembroInstitucional $membro): RedirectResponse
    {
        $membro->delete();

        return $this->voltarParaLista('Pessoa removida.');
    }

    private function formulario(MembroInstitucional $membro): View
    {
        return view('admin.equipe.form', [
            'membro' => $membro,
            'grupos' => MembroInstitucional::GRUPOS,
        ]);
    }

    private function validados(Request $request): array
    {
        $dados = $request->validate([
            'grupo' => ['required', Rule::in(array_keys(MembroInstitucional::GRUPOS))],
            'nome' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'ordem' => ['nullable', 'integer', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'nome.required' => 'Informe o nome.',
            'cargo.required' => 'Informe o cargo.',
            'foto.image' => 'A foto precisa ser uma imagem (JPG, PNG ou WEBP).',
            'foto.mimes' => 'A foto precisa ser JPG, PNG ou WEBP.',
            'foto.max' => 'A foto pode ter no máximo 4 MB.',
            'foto.uploaded' => 'Não foi possível enviar a foto. Ela pode ser maior que o limite do servidor.',
        ]);

        unset($dados['foto']);
        $dados['ordem'] = (int) ($dados['ordem'] ?? 0);
        $dados['foto_aproximada'] = $request->boolean('foto_aproximada');

        return $dados;
    }

    /** Campos da foto para gravar no banco. */
    private function camposDaFoto(UploadedFile $foto): array
    {
        return [
            'foto_nome' => Str::limit($foto->getClientOriginalName(), 250, ''),
            'foto_mime' => $foto->getMimeType(),
            'foto_data' => base64_encode(file_get_contents($foto->getRealPath())),
        ];
    }

    private function voltarParaLista(string $mensagem): RedirectResponse
    {
        return redirect()->route('admin.equipe.index')->with('status', $mensagem);
    }
}
