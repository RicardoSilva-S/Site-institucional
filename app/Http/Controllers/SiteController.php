<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

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
        $atualizacao = 'Setembro de 2026';
        $secoes = [
            ['id' => 'institucional', 'titulo' => 'Institucional', 'subtitulo' => 'Documentos de constituição e registro', 'docs' => [
              ['nome' => 'Estatuto Social consolidado', 'detalhe' => 'Registrado no RTDPJ de Sarandi/PR', 'status' => 'publicado'],
              ['nome' => 'Ata de Fundação', 'detalhe' => '11/07/2025 · Registro nº 508', 'status' => 'publicado'],
              ['nome' => 'Ata da Assembleia Geral Ordinária nº 01/2026', 'detalhe' => '02/01/2026 · Registro nº 508/01', 'status' => 'publicado'],
              ['nome' => 'Ata da Assembleia Geral Extraordinária nº 02/2026', 'detalhe' => '02/01/2026 · Registro nº 508/02', 'status' => 'publicado'],
              ['nome' => 'Regimento Interno', 'detalhe' => '02/01/2026', 'status' => 'publicado'],
              ['nome' => 'Comprovante de Inscrição no CNPJ', 'detalhe' => '64.039.593/0001-82', 'status' => 'publicado'],
            ]],
            ['id' => 'governanca', 'titulo' => 'Governança e gestão', 'subtitulo' => 'Composição, mandatos e decisões', 'docs' => [
              ['nome' => 'Composição da Diretoria Executiva e do Conselho', 'status' => 'publicado'],
              ['nome' => 'Atas de reunião da Diretoria Executiva', 'status' => 'publicacao'],
              ['nome' => 'Atas de reunião do Conselho Fiscal e Consultivo', 'status' => 'publicacao'],
            ]],
            ['id' => 'normativos', 'titulo' => 'Normativos internos', 'subtitulo' => 'Regras que o Instituto edita para si mesmo', 'docs' => [
              ['nome' => 'Regulamento de Contratações', 'status' => 'elaboracao'],
              ['nome' => 'Regulamento de Parcerias e Oportunidades de Negócio', 'status' => 'elaboracao'],
              ['nome' => 'Código de Ética, Conduta e Integridade', 'status' => 'elaboracao'],
              ['nome' => 'Política de Conflito de Interesses', 'status' => 'elaboracao'],
              ['nome' => 'Política de Inovação e Política de Propriedade Intelectual', 'status' => 'elaboracao'],
            ]],
            ['id' => 'parcerias', 'titulo' => 'Parcerias e contratos', 'subtitulo' => 'Termos e acordos firmados pelo Instituto', 'docs' => [
              ['nome' => 'Termo de Cooperação Técnica nº 001/2026 com a Compaxis Tecnologia Ltda', 'detalhe' => '05/08/2026 · sem transferência de recursos', 'status' => 'publicado'],
            ]],
            ['id' => 'contas', 'titulo' => 'Prestação de contas', 'subtitulo' => 'Demonstrativos e pareceres', 'docs' => [
              ['nome' => 'Demonstrações contábeis do exercício', 'status' => 'publicacao'],
              ['nome' => 'Parecer do Conselho Fiscal', 'status' => 'publicacao'],
              ['nome' => 'Relatório Anual de Atividades', 'status' => 'publicacao'],
            ]],
          ];
          
        return view('site.transparencia', compact('secoes', 'atualizacao'));
    }
}
