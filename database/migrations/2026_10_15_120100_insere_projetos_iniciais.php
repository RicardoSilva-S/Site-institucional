<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Cadastra os projetos que a página /projetos já mostrava quando os cartões
 * eram fixos na view. Daqui em diante, tudo é editado pelo painel
 * (/adm/projetos).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('projetos')->exists()) {
            return;
        }

        $agora = now();

        foreach ($this->projetos() as $ordem => $projeto) {
            DB::table('projetos')->insert(array_merge($projeto, [
                'ordem' => $ordem + 1,
                'created_at' => $agora,
                'updated_at' => $agora,
            ]));
        }
    }

    public function down(): void
    {
        DB::table('projetos')->delete();
    }

    private function projetos(): array
    {
        return [
            [
                'titulo' => 'Totem de Autoatendimento',
                'categorias' => 'Atendimento ao cidadão',
                'estagio' => 'implementado',
                'breve_descricao' => 'Reduz filas e facilita o acesso da população a serviços e informações municipais em pontos estratégicos de atendimento.',
                'tecnologia' => 'autoatendimento digital, interface acessível e integração com serviços públicos.',
                'link_rotulo' => 'Conhecer a solução',
                'link_destino' => 'contato',
            ],
            [
                'titulo' => 'Alô Câmara',
                'categorias' => 'Participação popular e legislativo',
                'estagio' => 'expansao',
                'breve_descricao' => 'Cria um canal direto entre a Câmara Municipal e os moradores para aproximar a população do trabalho dos vereadores.',
                'tecnologia' => 'comunicação digital, registro de demandas e acesso simplificado à informação.',
                'link_rotulo' => 'Conhecer a solução',
                'link_destino' => 'contato',
            ],
            [
                'titulo' => 'Lei Municipal de Inovação',
                'categorias' => 'Marco legal e segurança jurídica',
                'estagio' => 'consultoria',
                'breve_descricao' => 'Apoia o município na criação de um ambiente institucional capaz de estimular inovação, parcerias e modernização dos serviços.',
                'tecnologia' => 'diagnóstico normativo, estruturação regulatória e orientação para políticas públicas.',
                'link_rotulo' => 'Conhecer o marco legal',
                'link_destino' => 'marco-legal',
            ],
            [
                'titulo' => 'Gestão de Manutenção Municipal',
                'categorias' => 'Gestão municipal e operação',
                'estagio' => 'piloto',
                'breve_descricao' => 'Organiza solicitações, ordens de serviço e históricos de manutenção para dar mais previsibilidade à operação municipal.',
                'tecnologia' => 'gestão de chamados, acompanhamento de ativos e painéis de controle.',
                'link_rotulo' => 'Conhecer o projeto',
                'link_destino' => 'contato',
            ],
            [
                'titulo' => 'Mobilidade e Frota Pública',
                'categorias' => 'Mobilidade, frota e eficiência',
                'estagio' => 'desenvolvimento',
                'breve_descricao' => 'Ajuda o município a acompanhar veículos, deslocamentos e necessidades de manutenção, apoiando uma operação mais econômica e organizada.',
                'tecnologia' => 'monitoramento de ativos, indicadores operacionais e dados para tomada de decisão.',
                'link_rotulo' => 'Conhecer o projeto',
                'link_destino' => 'contato',
            ],
        ];
    }
};
