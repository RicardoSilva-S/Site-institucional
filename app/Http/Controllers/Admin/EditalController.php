<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edital;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Editais e chamamentos públicos (/adm/editais).
 *
 * O PDF do edital é guardado dentro do banco (arquivo_data e arquivo_nome),
 * igual aos documentos da transparência: no Render gratuito o disco do
 * servidor é apagado a cada reinício, então um arquivo salvo em pasta sumiria.
 */
class EditalController extends Controller
{
    // Tamanho máximo do PDF, em MB, mostrado no formulário. A regra de validação
    // usa o mesmo valor escrito direto ('max:5000', em KB), abaixo do limite de
    // upload do servidor (upload_max_filesize=5M no Dockerfile).
    private const TAMANHO_MAXIMO_MB = 5;

    public function index(): View
    {
        return view('admin.editais.index', [
            'editais' => Edital::paraLista(),
        ]);
    }

    public function create(): View
    {
        return $this->formulario(new Edital([
            'status' => 'aberto',
            'abertura' => now()->startOfDay(),
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validados($request);

        if ($request->hasFile('arquivo')) {
            $dados = array_merge($dados, $this->camposDoArquivo($request->file('arquivo')));
        }

        Edital::create($dados);

        return $this->voltarParaLista('Edital adicionado.');
    }

    public function edit(Edital $edital): View
    {
        return $this->formulario($edital);
    }

    public function update(Request $request, Edital $edital): RedirectResponse
    {
        $dados = $this->validados($request);

        if ($request->hasFile('arquivo')) {
            $dados = array_merge($dados, $this->camposDoArquivo($request->file('arquivo')));
        } elseif ($request->boolean('remover_arquivo')) {
            $dados['arquivo_nome'] = null;
            $dados['arquivo_data'] = null;
        }

        $edital->update($dados);

        return $this->voltarParaLista('Edital atualizado.');
    }

    public function destroy(Edital $edital): RedirectResponse
    {
        $edital->delete();

        return $this->voltarParaLista('Edital excluído.');
    }

    private function formulario(Edital $edital): View
    {
        return view('admin.editais.form', [
            'edital' => $edital,
            'status' => Edital::STATUS,
            'tamanhoMaximoMb' => self::TAMANHO_MAXIMO_MB,
        ]);
    }

    private function validados(Request $request): array
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'resumo' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', Rule::in(array_keys(Edital::STATUS))],
            'abertura' => ['nullable', 'date'],
            'encerramento' => ['nullable', 'date', 'after_or_equal:abertura'],
            'arquivo' => ['nullable', 'file', 'mimes:pdf', 'max:5000'],
        ], [
            'titulo.required' => 'Informe o título do edital.',
            'encerramento.after_or_equal' => 'O encerramento não pode ser antes da abertura.',
            'arquivo.mimes' => 'O arquivo precisa ser um PDF.',
            'arquivo.max' => 'O PDF pode ter no máximo ' . self::TAMANHO_MAXIMO_MB . ' MB.',
            'arquivo.uploaded' => 'Não foi possível enviar o PDF. Ele pode ser maior que o limite do servidor.',
        ]);

        unset($dados['arquivo']);

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
        return redirect()->route('admin.editais.index')->with('status', $mensagem);
    }
}
