<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Manifestacao enviada pelo formulario da Ouvidoria (pagina Contato).
 * Pode ser anonima: nesse caso nome, e-mail e telefone ficam vazios.
 */
class ManifestacaoOuvidoria extends Model
{
    protected $table = 'manifestacoes_ouvidoria';

    /** tipos aceitos e o nome mostrado no site e no painel */
    public const TIPOS = [
        'reclamacao' => 'Reclamação',
        'denuncia' => 'Denúncia',
        'sugestao' => 'Sugestão',
        'elogio' => 'Elogio',
        'solicitacao' => 'Solicitação de informação',
    ];

    public const STATUS_RECEBIDA = 'recebida';
    public const STATUS_RESPONDIDA = 'respondida';

    protected $fillable = [
        'tipo',
        'anonimo',
        'nome',
        'email',
        'telefone',
        'mensagem',
    ];

    protected $attributes = [
        'anonimo' => false,
        'status' => self::STATUS_RECEBIDA,
    ];

    protected $casts = [
        'anonimo' => 'boolean',
    ];

    /** numero que o cidadao recebe para acompanhar, ex: OUV-2026-00042 */
    public function protocolo(): string
    {
        return 'OUV-' . $this->created_at->format('Y') . '-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
    }

    public function nomeDoTipo(): string
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }

    public function estaRespondida(): bool
    {
        return $this->status === self::STATUS_RESPONDIDA;
    }

    public function alternarStatus(): void
    {
        $this->status = $this->estaRespondida() ? self::STATUS_RECEBIDA : self::STATUS_RESPONDIDA;
        $this->save();
    }
}
