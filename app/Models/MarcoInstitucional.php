<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Um marco da linha do tempo ("Nossa história") da página Institucional.
 * Cadastrado no painel em /adm/marcos.
 */
class MarcoInstitucional extends Model
{
    protected $table = 'marcos_institucionais';

    protected $fillable = [
        'data',
        'texto',
        'ordem',
    ];

    protected $casts = [
        'ordem' => 'integer',
    ];

    /** Todos os marcos, do mais antigo (ordem menor) para o mais recente. */
    public static function naOrdem()
    {
        return static::query()
            ->orderBy('ordem')
            ->orderBy('id')
            ->get();
    }
}