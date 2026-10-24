<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Um documento do Portal da Transparência (ex: Estatuto Social).
 *
 * O PDF fica no próprio banco, igual às imagens dos banners: "arquivo_data"
 * (conteúdo em base64) e "arquivo_nome" (nome original do arquivo). No Render
 * gratuito o disco é apagado quando o servidor reinicia, e o arquivo sumiria.
 */
class TransparenciaDocumento extends Model
{
    public const STATUS = [
        'publicado' => 'Disponível',
        'publicacao' => 'Em publicação',
        'elaboracao' => 'Em elaboração',
    ];

    // Colunas usadas nas listagens. Deixa de fora "arquivo_data" para não
    // carregar o PDF inteiro de cada documento só para mostrar a lista.
    public const COLUNAS_LISTA = [
        'id', 'secao_id', 'nome', 'detalhe', 'data_documento', 'status', 'arquivo_nome', 'ordem', 'created_at', 'updated_at',
    ];

    protected $table = 'transparencia_documentos';

    protected $fillable = [
        'secao_id',
        'nome',
        'detalhe',
        'data_documento',
        'status',
        'arquivo_nome',
        'arquivo_data',
        'ordem',
    ];

    // O conteúdo do PDF é grande: não entra quando o documento vira array/JSON.
    protected $hidden = [
        'arquivo_data',
    ];

    // Data do documento (ex.: a data da ata). Opcional.
    protected $casts = [
        'data_documento' => 'date',
    ];

    public function secao()
    {
        return $this->belongsTo(TransparenciaSecao::class, 'secao_id');
    }

    public function temArquivo(): bool
    {
        return ! empty($this->arquivo_nome);
    }

    /** endereco do PDF; o "v" muda quando o documento e editado, para o navegador baixar o novo */
    public function arquivoUrl(): string
    {
        return route('transparencia.documento', ['documento' => $this->id, 'v' => optional($this->updated_at)->timestamp]);
    }
}
