<?php

namespace App\Http\Controllers;

use App\Models\TransparenciaDocumento;
use App\Models\TransparenciaSecao;
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
        return view('site.institucional');
    }

    public function atuacao(): View
    {
        return view('site.atuacao');
    }

    public function contato(): View
    {
        return view('site.contato');
    }

    public function transparencia(): View
    {
        // Seções e documentos vêm do banco e são editados no painel (/adm/transparencia).
        $secoes = TransparenciaSecao::comDocumentos();
        $atualizacao = $this->ultimaAtualizacao($secoes);

        return view('site.transparencia', compact('secoes', 'atualizacao'));
    }

    /**
     * Entrega o PDF de um documento da transparência. O arquivo fica no banco
     * (igual às imagens dos banners), porque no Render gratuito o disco é
     * apagado quando o servidor reinicia.
     */
    public function documentoTransparencia(TransparenciaDocumento $documento): Response
    {
        abort_unless($documento->temArquivo() && $documento->arquivo_data, 404);

        return response(base64_decode($documento->arquivo_data), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_INLINE,
                str_replace(['/', '\\'], '-', $documento->arquivo_nome),
                $this->nomeSimples($documento->arquivo_nome)
            ),
        ]);
    }

    /**
     * Versão do nome só com letras, números, ponto, hífen e sublinhado, para
     * navegadores antigos (ex: "relatório 100%.pdf" vira "relatorio_100_.pdf").
     */
    private function nomeSimples(string $nome): string
    {
        return preg_replace('/[^A-Za-z0-9._-]/', '_', Str::ascii($nome)) ?: 'documento.pdf';
    }

    /** "Mês de ano" da última alteração feita no portal (ex: Outubro de 2026). */
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
}
