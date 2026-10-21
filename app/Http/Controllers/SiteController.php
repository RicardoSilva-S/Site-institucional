<?php

namespace App\Http\Controllers;

use App\Models\Edital;
use App\Models\MembroInstitucional;
use App\Models\Projeto;
use App\Models\TransparenciaDocumento;
use App\Models\TransparenciaSecao;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\HeaderUtils;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('site.home');
    }

    public function marcoLegal(): View
    {
        return view('site.marco-legal');
    }

    public function institucional(): View
    {
        // Diretoria e conselho vêm do banco e são editados no painel (/adm/equipe).
        return view('site.institucional', [
            'diretoria' => MembroInstitucional::doGrupo('diretoria'),
            'conselho' => MembroInstitucional::doGrupo('conselho'),
        ]);
    }

    /** Entrega a foto de uma pessoa da diretoria/conselho, guardada no banco. */
    public function fotoMembro(MembroInstitucional $membro): Response
    {
        abort_unless($membro->temFoto() && $membro->foto_data, 404);

        return response(base64_decode($membro->foto_data), 200, [
            'Content-Type' => $membro->foto_mime ?: 'image/jpeg',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    public function atuacao(): View
    {
        return view('site.atuacao');
    }

    public function projetos(): View
    {
        // Cartões do portfólio vêm do banco e são cadastrados no painel (/adm/projetos).
        return view('site.projetos', [
            'projetos' => Projeto::emOrdem(),
        ]);
    }

    public function editais(): View
    {
        // Editais vêm do banco e são cadastrados no painel (/adm/editais).
        $editais = Edital::paraLista();

        return view('site.editais', [
            'editais'  => $editais,
            'contagem' => $editais->countBy('status'),
        ]);
    }

    /** Entrega o PDF de um edital, guardado no banco. */
    public function pdfEdital(Edital $edital): Response
    {
        abort_unless($edital->temArquivo() && $edital->arquivo_data, 404);

        return response(base64_decode($edital->arquivo_data), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_INLINE,
                str_replace(['/', '\\'], '-', $edital->arquivo_nome),
                $this->nomeSimples($edital->arquivo_nome)
            ),
        ]);
    }

    public function contato(): View
    {
        return view('site.contato');
    }

    public function transparencia(): View
    {
        $secoes = TransparenciaSecao::comDocumentos();
        $atualizacao = $this->ultimaAtualizacao($secoes);

        return view('site.transparencia', compact('secoes', 'atualizacao'));
    }

    public function documentoTransparencia(Request $request, TransparenciaDocumento $documento): Response
    {
        abort_unless($documento->temArquivo() && $documento->arquivo_data, 404);

        // com o "v" no endereco (arquivoUrl) o PDF pode ficar no cache do navegador:
        // se o documento mudar, o endereco muda junto
        $cache = $request->has('v') ? 'public, max-age=31536000' : 'no-cache';

        return response(base64_decode($documento->arquivo_data), 200, [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => $cache,
            'Content-Disposition' => HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_INLINE,
                str_replace(['/', '\\'], '-', $documento->arquivo_nome),
                $this->nomeSimples($documento->arquivo_nome)
            ),
        ]);
    }

    private function nomeSimples(string $nome): string
    {
        return preg_replace('/[^A-Za-z0-9._-]/', '_', Str::ascii($nome)) ?: 'documento.pdf';
    }

    private function ultimaAtualizacao($secoes): ?string
    {
        $datas = $secoes->pluck('updated_at')
            ->merge($secoes->pluck('documentos')->flatten()->pluck('updated_at'))
            ->filter();

        if ($datas->isEmpty()) {
            return null;
        }

        return Str::ucfirst($datas->max()->locale('pt_BR')->isoFormat('MMMM [de] YYYY'));
    }
    
    public function privacidade(): View
    {
        return view('site.privacidade');
    }
}