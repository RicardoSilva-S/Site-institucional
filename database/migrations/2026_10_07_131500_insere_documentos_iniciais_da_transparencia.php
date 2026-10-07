<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Cadastra as seções e os documentos que o Portal da Transparência já
 * mostrava quando a lista era fixa no SiteController. Assim a página não fica
 * vazia depois do deploy. Daqui em diante, tudo é editado pelo painel
 * (/adm/transparencia).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('transparencia_secoes')->exists()) {
            return;
        }

        $agora = now();

        foreach ($this->secoes() as $ordemSecao => $secao) {
            $secaoId = DB::table('transparencia_secoes')->insertGetId([
                'slug' => $secao['slug'],
                'titulo' => $secao['titulo'],
                'subtitulo' => $secao['subtitulo'],
                'ordem' => $ordemSecao + 1,
                'created_at' => $agora,
                'updated_at' => $agora,
            ]);

            foreach ($secao['documentos'] as $ordemDoc => $doc) {
                DB::table('transparencia_documentos')->insert([
                    'secao_id' => $secaoId,
                    'nome' => $doc[0],
                    'detalhe' => $doc[1],
                    'status' => $doc[2],
                    'ordem' => $ordemDoc + 1,
                    'created_at' => $agora,
                    'updated_at' => $agora,
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('transparencia_documentos')->delete();
        DB::table('transparencia_secoes')->delete();
    }

    /** Documentos: [nome, detalhe, status] */
    private function secoes(): array
    {
        return [
            ['slug' => 'institucional', 'titulo' => 'Institucional', 'subtitulo' => 'Documentos de constituição e registro', 'documentos' => [
                ['Estatuto Social consolidado', 'Registrado no RTDPJ de Sarandi/PR', 'publicado'],
                ['Ata de Fundação', '11/07/2025 · Registro nº 508', 'publicado'],
                ['Ata da Assembleia Geral Ordinária nº 01/2026', '02/01/2026 · Registro nº 508/01', 'publicado'],
                ['Ata da Assembleia Geral Extraordinária nº 02/2026', '02/01/2026 · Registro nº 508/02', 'publicado'],
                ['Regimento Interno', '02/01/2026', 'publicado'],
                ['Comprovante de Inscrição no CNPJ', '64.039.593/0001-82', 'publicado'],
            ]],
            ['slug' => 'governanca', 'titulo' => 'Governança e gestão', 'subtitulo' => 'Composição, mandatos e decisões', 'documentos' => [
                ['Composição da Diretoria Executiva e do Conselho', null, 'publicado'],
                ['Atas de reunião da Diretoria Executiva', null, 'publicacao'],
                ['Atas de reunião do Conselho Fiscal e Consultivo', null, 'publicacao'],
            ]],
            ['slug' => 'normativos', 'titulo' => 'Normativos internos', 'subtitulo' => 'Regras que o Instituto edita para si mesmo', 'documentos' => [
                ['Regulamento de Contratações', null, 'elaboracao'],
                ['Regulamento de Parcerias e Oportunidades de Negócio', null, 'elaboracao'],
                ['Código de Ética, Conduta e Integridade', null, 'elaboracao'],
                ['Política de Conflito de Interesses', null, 'elaboracao'],
                ['Política de Inovação e Política de Propriedade Intelectual', null, 'elaboracao'],
            ]],
            ['slug' => 'parcerias', 'titulo' => 'Parcerias e contratos', 'subtitulo' => 'Termos e acordos firmados pelo Instituto', 'documentos' => [
                ['Termo de Cooperação Técnica nº 001/2026 com a Compaxis Tecnologia Ltda', '05/08/2026 · sem transferência de recursos', 'publicado'],
            ]],
            ['slug' => 'contas', 'titulo' => 'Prestação de contas', 'subtitulo' => 'Demonstrativos e pareceres', 'documentos' => [
                ['Demonstrações contábeis do exercício', null, 'publicacao'],
                ['Parecer do Conselho Fiscal', null, 'publicacao'],
                ['Relatório Anual de Atividades', null, 'publicacao'],
            ]],
        ];
    }
};
