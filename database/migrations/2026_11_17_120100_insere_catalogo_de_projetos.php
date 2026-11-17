<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Troca os cartões iniciais da página /projetos pelo catálogo do modelo
 * antigo (idtnpr.org.br/projetos.html): Acquora, Compaxis Connect,
 * ConciliadorNF, Alô Câmara, Estrutura Municipal de Inovação e Capacitação
 * de Servidores.
 *
 * - Cada solução é gravada pelo slug: se já existir (deploy repetido, ou
 *   editada no painel), não é tocada.
 * - Os cartões de exemplo da migration 2026_10_15_120100 que não fazem parte
 *   do catálogo são apagados. Projetos com outros títulos, cadastrados no
 *   painel, ficam como estão.
 */
return new class extends Migration
{
    /** Cartões de exemplo da migration insere_projetos_iniciais. */
    private const CARTOES_ANTIGOS = [
        'Totem de Autoatendimento',
        'Lei Municipal de Inovação',
        'Gestão de Manutenção Municipal',
        'Mobilidade e Frota Pública',
    ];

    public function up(): void
    {
        DB::table('projetos')->whereIn('titulo', self::CARTOES_ANTIGOS)->delete();

        $agora = now();

        foreach ($this->catalogo() as $ordem => $projeto) {
            $dados = array_merge($projeto, ['ordem' => $ordem + 1, 'updated_at' => $agora]);

            // O "Alô Câmara" de exemplo já existia: vira o do catálogo.
            $existente = DB::table('projetos')
                ->where('slug', $projeto['slug'])
                ->orWhere('titulo', $projeto['titulo'])
                ->first();

            if ($existente === null) {
                DB::table('projetos')->insert($dados + ['created_at' => $agora]);
            } elseif ($existente->titulo === 'Alô Câmara' && $existente->estagio === 'expansao') {
                DB::table('projetos')->where('id', $existente->id)->update($dados);
            }
        }
    }

    public function down(): void
    {
        // Nada a desfazer: os cartões passam a ser mantidos pelo painel.
    }

    private function catalogo(): array
    {
        $link = ['link_rotulo' => 'Solicitar reunião técnica', 'link_destino' => 'contato'];

        return [
            [
                'titulo' => 'Acquora',
                'slug' => 'acquora',
                'categorias' => 'Saneamento',
                'icone' => 'saneamento',
                'estagio' => 'implementado',
                'breve_descricao' => 'Gestão da manutenção de poços, tanques, bombas e periféricos para autarquias municipais de água e esgoto, com geolocalização dos ativos e alçadas de autorização.',
                'tecnologia' => null,
            ] + $link,
            [
                'titulo' => 'Compaxis Connect',
                'slug' => 'compaxis-connect',
                'categorias' => 'Autoatendimento',
                'icone' => 'autoatendimento',
                'estagio' => 'implementado',
                'breve_descricao' => 'Terminais de autoatendimento para o cidadão emitir guias, pagar tributos e tirar certidões sozinho, sem fila e sem depender do horário de expediente.',
                'tecnologia' => null,
            ] + $link,
            [
                'titulo' => 'ConciliadorNF',
                'slug' => 'conciliadornf',
                'categorias' => 'Fiscal',
                'icone' => 'fiscal',
                'estagio' => 'desenvolvimento',
                'breve_descricao' => 'Captura na SEFAZ todos os documentos fiscais emitidos contra os CNPJs do município e apoia a conciliação entre o que foi faturado e o que já está liquidado.',
                'tecnologia' => null,
            ] + $link,
            [
                'titulo' => 'Alô Câmara',
                'slug' => 'alo-camara',
                'categorias' => 'Legislativo',
                'icone' => 'legislativo',
                'estagio' => 'desenvolvimento',
                'breve_descricao' => 'Canal oficial e registrado entre o cidadão e o vereador, reunindo em um só lugar solicitações, pedidos e agendamentos hoje espalhados por redes sociais e WhatsApp.',
                'tecnologia' => null,
            ] + $link,
            [
                'titulo' => 'Estrutura Municipal de Inovação',
                'slug' => 'estrutura-municipal-de-inovacao',
                'categorias' => 'Jurídico',
                'icone' => 'juridico',
                'estagio' => 'implementado',
                'breve_descricao' => 'Implantação da estrutura de inovação e tecnologia do município: a lei, o decreto, o conselho e o fundo que dão existência legal à política municipal e habilitam o acesso ao fomento estadual.',
                'tecnologia' => null,
                'link_rotulo' => 'Ver o Marco Legal',
                'link_destino' => 'marco-legal',
            ],
            [
                'titulo' => 'Capacitação de Servidores',
                'slug' => 'capacitacao-de-servidores',
                'categorias' => 'Formação',
                'icone' => 'formacao',
                'estagio' => 'implementado',
                'breve_descricao' => 'Trilhas em inovação, instrumentos de contratação, governo digital e proteção de dados, ajustadas ao perfil da turma, com material próprio e certificação.',
                'tecnologia' => null,
            ] + $link,
        ];
    }
};
