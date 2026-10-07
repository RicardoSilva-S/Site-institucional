<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Uma seção do Portal da Transparência (ex: Institucional, Prestação de contas).
 * Cada seção tem vários documentos.
 */
class TransparenciaSecao extends Model
{
    protected $table = 'transparencia_secoes';

    protected $fillable = [
        'slug',
        'titulo',
        'subtitulo',
        'ordem',
    ];

    public function documentos()
    {
        return $this->hasMany(TransparenciaDocumento::class, 'secao_id')->orderBy('ordem')->orderBy('id');
    }

    /** Seções em ordem, com os documentos (sem o conteúdo dos PDFs). */
    public static function comDocumentos()
    {
        return static::query()
            ->with(['documentos' => function ($query) {
                $query->select(TransparenciaDocumento::COLUNAS_LISTA);
            }])
            ->orderBy('ordem')
            ->orderBy('id')
            ->get();
    }
}
