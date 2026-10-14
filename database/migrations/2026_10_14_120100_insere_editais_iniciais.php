<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Cadastra os editais que a página /editais já mostrava quando a lista era
 * fixa no SiteController. Daqui em diante, tudo é editado pelo painel
 * (/adm/editais), onde também se envia o PDF de cada edital.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('editais')->exists()) {
            return;
        }

        $agora = now();

        foreach ($this->editais() as $edital) {
            DB::table('editais')->insert(array_merge($edital, [
                'created_at' => $agora,
                'updated_at' => $agora,
            ]));
        }
    }

    public function down(): void
    {
        DB::table('editais')->delete();
    }

    private function editais(): array
    {
        return [
            [
                'titulo' => 'Chamamento Público nº 004/2026 – Soluções de Transparência e Participação Legislativa para Câmaras Municipais',
                'resumo' => 'Seleção de soluções tecnológicas que aproximem o Poder Legislativo municipal da população, com canais digitais de atendimento aos vereadores, acompanhamento de proposições e divulgação de sessões e votações.',
                'status' => 'aberto',
                'abertura' => '2026-10-05',
                'encerramento' => '2026-11-20',
            ],
            [
                'titulo' => 'Chamamento Público nº 003/2026 – Plataformas de Atendimento ao Cidadão e Autoatendimento',
                'resumo' => 'Credenciamento de soluções de autoatendimento, como totens, aplicativos e portais de serviços, que reduzam filas e agilizem a emissão de documentos e o protocolo de solicitações nas prefeituras.',
                'status' => 'aberto',
                'abertura' => '2026-09-01',
                'encerramento' => '2026-10-30',
            ],
            [
                'titulo' => 'Chamamento Público nº 002/2026 – Gestão e Controle de Frotas e Obras Municipais',
                'resumo' => 'Seleção de sistemas para planejamento de manutenção, controle de frotas, registro de ordens de serviço e acompanhamento de obras, com relatórios que apoiem a prestação de contas.',
                'status' => 'analise',
                'abertura' => '2026-07-15',
                'encerramento' => '2026-09-14',
            ],
            [
                'titulo' => 'Chamamento Público nº 001/2026 – Credenciamento de Soluções de Cidades Inteligentes',
                'resumo' => 'Credenciamento de soluções de monitoramento urbano, mobilidade e serviços digitais para municípios do noroeste paranaense. Chamamento homologado, com resultado final publicado.',
                'status' => 'encerrado',
                'abertura' => '2026-03-02',
                'encerramento' => '2026-04-30',
            ],
        ];
    }
};
