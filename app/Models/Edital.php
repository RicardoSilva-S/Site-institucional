<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Um edital/chamamento público da página /editais.
 *
 * O PDF fica no próprio banco, igual aos documentos da transparência:
 * "arquivo_data" (conteúdo em base64) e "arquivo_nome" (nome original).
 * O site baixa o PDF pela rota pública /editais/{id}/pdf.
 */
class Edital extends Model
{
    /** Situações do edital: rótulo e classe CSS da etiqueta (style.css). */
    public const STATUS = [
        'aberto' => ['rotulo' => 'Aberto', 'classe' => 'publicado'],
        'analise' => ['rotulo' => 'Em análise', 'classe' => 'elaboracao'],
        'encerrado' => ['rotulo' => 'Encerrado', 'classe' => ''],
    ];

    // Colunas usadas nas listagens. Deixa de fora "arquivo_data" para não
    // carregar o PDF inteiro de cada edital só para mostrar a lista.
    public const COLUNAS_LISTA = [
        'id', 'titulo', 'resumo', 'status', 'abertura', 'encerramento', 'arquivo_nome', 'created_at', 'updated_at',
    ];

    protected $table = 'editais';

    protected $fillable = [
        'titulo',
        'resumo',
        'status',
        'abertura',
        'encerramento',
        'arquivo_nome',
        'arquivo_data',
    ];

    protected $casts = [
        'abertura' => 'date',
        'encerramento' => 'date',
    ];

    protected $hidden = [
        'arquivo_data',
    ];

    /** Editais do mais recente para o mais antigo, sem o conteúdo dos PDFs. */
    public static function paraLista()
    {
        return static::query()
            ->select(self::COLUNAS_LISTA)
            ->orderByDesc('abertura')
            ->orderByDesc('id')
            ->get();
    }

    public function rotulo(): string
    {
        return self::STATUS[$this->status]['rotulo'] ?? $this->status;
    }

    public function classe(): string
    {
        return self::STATUS[$this->status]['classe'] ?? '';
    }

    public function temArquivo(): bool
    {
        return ! empty($this->arquivo_nome);
    }

    /** Texto do botão do PDF: edital encerrado costuma publicar o resultado. */
    public function acao(): string
    {
        return $this->status === 'encerrado' ? 'Acessar resultado' : 'Baixar edital';
    }
}
