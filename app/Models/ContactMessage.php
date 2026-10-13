<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    /** Opções do campo "Área do problema" (usadas na view e na validação). */
    public const AREAS = [
        'Atendimento ao cidadão',
        'Tributos e arrecadação',
        'Contabilidade e prestação de contas',
        'Manutenção e serviços públicos',
        'Câmara Municipal',
        'Lei de inovação e política de CT&I',
        'Capacitação de servidores',
        'Outro',
    ];

    protected $fillable = [
        'nome',
        'cargo',
        'orgao',
        'email',
        'telefone',
        'area',
        'mensagem',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
