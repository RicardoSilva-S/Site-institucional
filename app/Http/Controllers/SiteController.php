<?php

namespace App\Http\Controllers;

use App\Models\TransparenciaDocumento;
use App\Models\TransparenciaSecao;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Illuminate\Support\Carbon;

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

    public function projetos(): View
    {
        return view('site.projetos');
    }

    public function editais(): View
    {
        $editais = collect([
            [
                'status'       => 'aberto',
                'rotulo'       => 'Aberto',
                'classe'       => 'publicado',
                'titulo'       => 'Chamamento Público nº 004/2026 – Soluções de Transparência e Participação Legislativa para Câmaras Municipais',
                'resumo'       => 'Seleção de soluções tecnológicas que aproximem o Poder Legislativo municipal da população, com canais digitais de atendimento aos vereadores, acompanhamento de proposições e divulgação de sessões e votações.',
                'abertura'     => Carbon::create(2026, 10, 5),
                'encerramento' => Carbon::create(2026, 11, 20),
                'acao'         => 'Baixar edital',
                'url'          => '#',
            ],
            [
                'status'       => 'aberto',
                'rotulo'       => 'Aberto',
                'classe'       => 'publicado',
                'titulo'       => 'Chamamento Público nº 003/2026 – Plataformas de Atendimento ao Cidadão e Autoatendimento',
                'resumo'       => 'Credenciamento de soluções de autoatendimento, como totens, aplicativos e portais de serviços, que reduzam filas e agilizem a emissão de documentos e o protocolo de solicitações nas prefeituras.',
                'abertura'     => Carbon::create(2026, 9, 1),
                'encerramento' => Carbon::create(2026, 10, 30),
                'acao'         => 'Baixar edital',
                'url'          => '#',
            ],
            [
                'status'       => 'analise',
                'rotulo'       => 'Em análise',
                'classe'       => 'elaboracao',
                'titulo'       => 'Chamamento Público nº 002/2026 – Gestão e Controle de Frotas e Obras Municipais',
                'resumo'       => 'Seleção de sistemas para planejamento de manutenção, controle de frotas, registro de ordens de serviço e acompanhamento de obras, com relatórios que apoiem a prestação de contas.',
                'abertura'     => Carbon::create(2026, 7, 15),
                'encerramento' => Carbon::create(2026, 9, 14),
                'acao'         => 'Baixar edital',
                'url'          => '#',
            ],
            [
                'status'       => 'encerrado',
                'rotulo'       => 'Encerrado',
                'classe'       => '',
                'titulo'       => 'Chamamento Público nº 001/2026 – Credenciamento de Soluções de Cidades Inteligentes',
                'resumo'       => 'Credenciamento de soluções de monitoramento urbano, mobilidade e serviços digitais para municípios do noroeste paranaense. Chamamento homologado, com resultado final publicado.',
                'abertura'     => Carbon::create(2026, 3, 2),
                'encerramento' => Carbon::create(2026, 4, 30),
                'acao'         => 'Acessar resultado',
                'url'          => '#',
            ],
        ]);

        return view('site.editais', [
            'editais'  => $editais,
            'contagem' => $editais->countBy('status'),
        ]);
    }

    public function contato(): View
    {
        return view('site.contato');
    }

    public function enviarContato(Request $request)
    {
        return redirect()->back()->with('success', 'Mensagem enviada com sucesso!');
    }

    public function transparencia(): View
    {
        $secoes = TransparenciaSecao::comDocumentos();
        $atualizacao = $this->ultimaAtualizacao($secoes);

        return view('site.transparencia', compact('secoes', 'atualizacao'));
    }

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