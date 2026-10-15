<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Um projeto/solução do portfólio da página /projetos (um cartão).
 */
class Projeto extends Model
{
    /** Estágios do projeto: rótulo e classe CSS da etiqueta (style.css). */
    public const ESTAGIOS = [
        'implementado' => ['rotulo' => 'Implementado', 'classe' => 'publicado'],
        'expansao' => ['rotulo' => 'Em expansão', 'classe' => ''],
        'consultoria' => ['rotulo' => 'Consultoria', 'classe' => ''],
        'piloto' => ['rotulo' => 'Fase piloto', 'classe' => 'elaboracao'],
        'desenvolvimento' => ['rotulo' => 'Desenvolvimento', 'classe' => ''],
    ];

    /** Páginas para onde o link do cartão pode levar (nome da rota => rótulo no painel). */
    public const DESTINOS = [
        'contato' => 'Contato',
        'marco-legal' => 'Marco Legal',
        'atuacao' => 'Atuação',
        'editais' => 'Editais',
        'transparencia' => 'Transparência',
    ];

    protected $table = 'projetos';

    protected $fillable = [
        'titulo',
        'breve_descricao',
        'categorias',
        'estagio',
        'tecnologia',
        'link_rotulo',
        'link_destino',
        'ordem',
    ];

    /** Projetos na ordem em que aparecem na página. */
    public static function emOrdem()
    {
        return static::query()->orderBy('ordem')->orderBy('id')->get();
    }

    public function rotulo(): string
    {
        return self::ESTAGIOS[$this->estagio]['rotulo'] ?? $this->estagio;
    }

    public function classe(): string
    {
        return self::ESTAGIOS[$this->estagio]['classe'] ?? '';
    }

    /** Endereço do link do cartão (se o destino não existir mais, vai para Contato). */
    public function linkUrl(): string
    {
        return route(array_key_exists($this->link_destino, self::DESTINOS) ? $this->link_destino : 'contato');
    }
}
