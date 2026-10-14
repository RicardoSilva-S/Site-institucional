<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Uma pessoa da diretoria ou do conselho (página Institucional).
 *
 * A foto fica no próprio banco, igual às imagens dos banners: "foto_data"
 * (conteúdo em base64), "foto_mime" e "foto_nome". O site busca a foto pela
 * rota pública /equipe/{id}/foto.
 */
class MembroInstitucional extends Model
{
    public const GRUPOS = [
        'diretoria' => 'Diretoria executiva',
        'conselho' => 'Conselho',
    ];

    // Colunas usadas nas listagens. Deixa de fora "foto_data" para não
    // carregar a foto inteira de cada pessoa só para mostrar a lista.
    public const COLUNAS_LISTA = [
        'id', 'grupo', 'nome', 'cargo', 'bio', 'foto_nome', 'foto_mime', 'foto_aproximada', 'ordem', 'created_at', 'updated_at',
    ];

    protected $table = 'membros_institucionais';

    protected $fillable = [
        'grupo',
        'nome',
        'cargo',
        'bio',
        'foto_nome',
        'foto_mime',
        'foto_data',
        'foto_aproximada',
        'ordem',
    ];

    protected $casts = [
        'foto_aproximada' => 'boolean',
    ];

    protected $hidden = [
        'foto_data',
    ];

    /** Pessoas de um grupo, na ordem, sem o conteúdo das fotos. */
    public static function doGrupo(string $grupo)
    {
        return static::query()
            ->select(self::COLUNAS_LISTA)
            ->where('grupo', $grupo)
            ->orderBy('ordem')
            ->orderBy('id')
            ->get();
    }

    public function temFoto(): bool
    {
        return ! empty($this->foto_nome);
    }

    /**
     * Endereço da foto. O "v" muda quando a pessoa é editada, para o
     * navegador baixar a foto nova em vez de usar a que guardou em cache.
     */
    public function fotoUrl(): string
    {
        return route('equipe.foto', ['membro' => $this->id, 'v' => optional($this->updated_at)->timestamp]);
    }

    /** Iniciais do primeiro e do último nome (ex: Walmir Rafael da Silva → WS). */
    public function sigla(): string
    {
        $partes = preg_split('/\s+/', trim($this->nome));
        $primeira = Str::substr($partes[0] ?? '', 0, 1);
        $ultima = count($partes) > 1 ? Str::substr(end($partes), 0, 1) : '';

        return Str::upper($primeira . $ultima);
    }
}
