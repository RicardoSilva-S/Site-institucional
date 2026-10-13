<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Cadastra a diretoria e o conselho que a página Institucional já mostrava
 * quando a lista era fixa na view. As fotos atuais (public/assets/equipe)
 * são copiadas para o banco. Daqui em diante, tudo é editado pelo painel
 * (/adm/equipe).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('membros_institucionais')->exists()) {
            return;
        }

        $agora = now();

        foreach ($this->membros() as $ordem => $membro) {
            DB::table('membros_institucionais')->insert(array_merge([
                'grupo' => $membro['grupo'],
                'nome' => $membro['nome'],
                'cargo' => $membro['cargo'],
                'bio' => $membro['bio'] ?? null,
                'foto_aproximada' => $membro['foto_aproximada'] ?? false,
                'ordem' => $ordem + 1,
                'created_at' => $agora,
                'updated_at' => $agora,
            ], $this->foto($membro['foto'] ?? null)));
        }
    }

    public function down(): void
    {
        DB::table('membros_institucionais')->delete();
    }

    /** Campos da foto a partir de um arquivo de public/assets/equipe. */
    private function foto(?string $arquivo): array
    {
        $caminho = $arquivo ? public_path('assets/equipe/' . $arquivo) : null;

        if (! $caminho || ! is_file($caminho)) {
            return [];
        }

        return [
            'foto_nome' => $arquivo,
            'foto_mime' => 'image/jpeg',
            'foto_data' => base64_encode(file_get_contents($caminho)),
        ];
    }

    private function membros(): array
    {
        return [
            ['grupo' => 'diretoria', 'nome' => 'Jonny de Souza Ribeiro', 'cargo' => 'Presidência', 'foto' => 'jonny.jpg', 'foto_aproximada' => true,
             'bio' => 'Economista com pós-graduação em Controladoria e Finanças, com experiência em tecnologia, análise econômica aplicada à gestão pública e projetos de inovação.'],
            ['grupo' => 'diretoria', 'nome' => 'Gilmar Boti Júnior', 'cargo' => 'Diretoria administrativa', 'foto' => 'gilmar.jpg',
             'bio' => 'Graduado em Processos Gerenciais e Gestão Pública, com mais de dez anos de atuação direta no setor público e na administração de contratos.'],
            ['grupo' => 'diretoria', 'nome' => 'Bruno Nascimento', 'cargo' => 'Projetos e tecnologia', 'foto' => 'bruno.jpg',
             'bio' => 'Bacharel em Gestão Pública, consultor e empresário com experiência em processos, modernização administrativa e implantação de sistemas.'],
            ['grupo' => 'conselho', 'nome' => 'Vinicius Cancian', 'cargo' => 'Presidente do conselho'],
            ['grupo' => 'conselho', 'nome' => 'Anderson de Jesus Ciriaco Lopes', 'cargo' => 'Conselheiro fiscal'],
            ['grupo' => 'conselho', 'nome' => 'Walmir Rafael da Silva', 'cargo' => 'Conselheiro consultivo'],
        ];
    }
};
