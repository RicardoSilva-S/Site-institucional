<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Leva os 5 passos da linha do tempo, que eram textos fixos do painel
 * (institucional.passo1 a passo5), para a tabela marcos_institucionais.
 *
 * Se algum passo foi editado no painel, a versão editada é a que vai;
 * passo excluído no painel (data e texto vazios) não é copiado. Depois
 * apaga os textos antigos, para eles não aparecerem mais no painel.
 */
return new class extends Migration
{
    private const PADRAO = [
        1 => ['Jul · 2025', 'Constituição do Instituto em assembleia de fundação, com aprovação do Estatuto Social e eleição da primeira Diretoria.'],
        2 => ['Set · 2025', 'Inscrição no Cadastro Nacional da Pessoa Jurídica, habilitando o Instituto a firmar instrumentos e operar formalmente.'],
        3 => ['Jan · 2026', 'Eleição da Diretoria Executiva e do Conselho Fiscal e Consultivo, com aprovação do Regimento Interno.'],
        4 => ['2026', 'Primeira entrega técnica: elaboração de minuta para a Política Municipal de Ciência, Tecnologia e Inovação de Sarandi.'],
        5 => ['Ago · 2026', 'Primeira parceria com desenvolvedora, inaugurando a carteira de soluções tecnológicas do Instituto.'],
    ];

    public function up(): void
    {
        $temTextos = Schema::hasTable('site_texts');

        $atuais = $temTextos
            ? DB::table('site_texts')->where('key', 'like', 'institucional.passo%')->pluck('value', 'key')
            : collect();

        $agora = now();
        $ordem = 0;

        foreach (self::PADRAO as $i => [$data, $texto]) {
            $data = trim((string) $atuais->get("institucional.passo{$i}.title", $data));
            $texto = trim((string) $atuais->get("institucional.passo{$i}.text", $texto));

            if ($data === '' && $texto === '') {
                continue;
            }

            $ordem++;

            DB::table('marcos_institucionais')->insert([
                'data' => $data,
                'texto' => $texto,
                'ordem' => $ordem,
                'created_at' => $agora,
                'updated_at' => $agora,
            ]);
        }

        if ($temTextos) {
            DB::table('site_texts')->where('key', 'like', 'institucional.passo%')->delete();
        }
    }

    public function down(): void
    {
        DB::table('marcos_institucionais')->delete();
    }
};