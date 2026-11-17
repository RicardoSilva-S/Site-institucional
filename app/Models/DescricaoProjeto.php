<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Um bloco de texto (título + texto) da página de detalhe de um projeto.
 * Tabela criada por 2026_10_15_130100_create_descricao_projetos_table.
 */
class DescricaoProjeto extends Model
{
    protected $table = 'descricao_projetos';

    protected $fillable = ['projeto_id', 'titulo', 'texto'];

    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projeto::class);
    }
}
