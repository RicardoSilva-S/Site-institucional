<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransparenciaDocumento;
use App\Models\TransparenciaSecao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Documentos do Portal da Transparência no painel (/adm/transparencia).
 *
 * O PDF é guardado dentro do banco (colunas arquivo_data e arquivo_nome),
 * igual às imagens dos banners: no Render gratuito o disco do servidor é
 * apagado a cada reinício, então um arquivo salvo em pasta sumiria.
 */
class TransparenciaDocumentoController extends Controller
{
    // Tamanho máximo do PDF, em MB, mostrado no formulário. A regra de validação
    // usa o mesmo valor escrito direto ('max:5000', em KB), abaixo do limite de
    // upload do servidor (upload_max_filesize=5M no Dockerfile).
    private const TAMANHO_MAXIMO_MB = 5;

    public function create(Request $request): View
    {
        $secaoId = (int) $request->query('secao');
        $proximaOrdem = (int) TransparenciaDocumento::where('secao_id', $secaoId)->max('ordem') + 1;

        return $this->formulario(new TransparenciaDocumento([
            'secao_id' => $secaoId ?: null,
            'status' => 'publicado',
            'ordem' => $proximaOrdem,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validados($request);

        if ($request->hasFile('arquivo')) {
            $dados = array_merge($dados, $this->camposDoArquivo($request->file('arquivo')));
        }

        TransparenciaDocumento::create($dados);

        return $this->voltarParaLista('Documento adicionado.');
    }

    public function edit(TransparenciaDocumento $documento): View
    {
        return $this->formulario($documento);
    }

    public function update(Request $request, TransparenciaDocumento $documento): RedirectResponse
    {
        $dados = $this->validados($request);

        if ($request->hasFile('arquivo')) {
            $dados = array_merge($dados, $this->camposDoArquivo($request->file('arquivo')));
        } elseif ($request->boolean('remover_arquivo')) {
            $dados['arquivo_nome'] = null;
            $dados['arquivo_data'] = null;
        }

        $documento->update($dados);

        return $this->voltarParaLista('Documento atualizado.');
    }

    public function destroy(TransparenciaDocumento $documento): RedirectResponse
    {
        $documento->delete();

        return $this->voltarParaLista('Documento excluído.');
    }

    private function formulario(TransparenciaDocumento $documento): View
    {
        return view('admin.transparencia.documento-form', [
            'documento' => $documento,
            'secoes' => TransparenciaSecao::orderBy('ordem')->orderBy('id')->get(),
            'status' => TransparenciaDocumento::STATUS,
            'tamanhoMaximoMb' => self::TAMANHO_MAXIMO_MB,
        ]);
    }

    private function validados(Request $request): array
    {
        $dados = $request->validate([
            'secao_id' => ['required', 'integer', 'exists:transparencia_secoes,id'],
            'nome' => ['required', 'string', 'max:255'],
            'detalhe' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_keys(TransparenciaDocumento::STATUS))],
            'ordem' => ['nullable', 'integer', 'min:0'],
            'arquivo' => ['nullable', 'file', 'mimes:pdf', 'max:5000'],
        ], [
            'secao_id.required' => 'Escolha a seção do documento.',
            'secao_id.exists' => 'A seção escolhida não existe mais.',
            'nome.required' => 'Informe o nome do documento.',
            'arquivo.mimes' => 'O arquivo precisa ser um PDF.',
            'arquivo.max' => 'O PDF pode ter no máximo ' . self::TAMANHO_MAXIMO_MB . ' MB.',
            'arquivo.uploaded' => 'Não foi possível enviar o PDF. Ele pode ser maior que o limite do servidor.',
        ]);

        unset($dados['arquivo']);
        $dados['ordem'] = (int) ($dados['ordem'] ?? 0);

        return $dados;
    }

    /** Campos do PDF para gravar no banco. */
    private function camposDoArquivo(UploadedFile $arquivo): array
    {
        return [
            'arquivo_nome' => Str::limit($arquivo->getClientOriginalName(), 250, ''),
            'arquivo_data' => base64_encode(file_get_contents($arquivo->getRealPath())),
        ];
    }

    private function voltarParaLista(string $mensagem): RedirectResponse
    {
        return redirect()->route('admin.transparencia.index')->with('status', $mensagem);
    }
}
