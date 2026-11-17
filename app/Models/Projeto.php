<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Um projeto/solução do catálogo da página /projetos (um cartão) e a página
 * de detalhe dele (/projetos/{slug}).
 */
class Projeto extends Model
{
    /**
     * Estágios do projeto: rótulo do selo e classe CSS dele (.status no
     * style.css). "implementado" e "desenvolvimento" são os do catálogo:
     * Disponível (verde) e Em desenvolvimento (âmbar).
     */
    public const ESTAGIOS = [
        'implementado' => ['rotulo' => 'Disponível', 'classe' => 'publicado'],
        'desenvolvimento' => ['rotulo' => 'Em desenvolvimento', 'classe' => 'elaboracao'],
        'piloto' => ['rotulo' => 'Fase piloto', 'classe' => 'elaboracao'],
        'expansao' => ['rotulo' => 'Em expansão', 'classe' => ''],
        'consultoria' => ['rotulo' => 'Consultoria', 'classe' => ''],
    ];

    /** Ícones do cartão (desenhados em components/projeto-icone.blade.php). */
    public const ICONES = [
        'padrao' => 'Genérico',
        'saneamento' => 'Saneamento (água)',
        'autoatendimento' => 'Autoatendimento (terminal)',
        'fiscal' => 'Fiscal (documento)',
        'legislativo' => 'Legislativo (sinal)',
        'juridico' => 'Jurídico (balança)',
        'formacao' => 'Formação (capelo)',
    ];

    /** Páginas para onde o botão da página de detalhe pode levar (nome da rota => rótulo no painel). */
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
        'slug',
        'breve_descricao',
        'categorias',
        'icone',
        'estagio',
        'problema',
        'tecnologia',
        'link_rotulo',
        'link_destino',
        'ordem',
    ];

    /** Sem slug informado, gera um a partir do título (único na tabela). */
    protected static function booted(): void
    {
        static::saving(function (Projeto $projeto) {
            if (blank($projeto->slug)) {
                $projeto->slug = static::slugUnico($projeto->titulo, $projeto->id);
            }
        });
    }

    public static function slugUnico(string $titulo, ?int $ignorarId = null): string
    {
        $base = Str::slug($titulo) ?: 'projeto';
        $slug = $base;

        for ($n = 2; static::query()->where('slug', $slug)->when($ignorarId, fn ($q) => $q->whereKeyNot($ignorarId))->exists(); $n++) {
            $slug = "{$base}-{$n}";
        }

        return $slug;
    }

    /** Projetos na ordem em que aparecem na página. */
    public static function emOrdem()
    {
        return static::query()->orderBy('ordem')->orderBy('id')->get();
    }

    /** Blocos de texto da página de detalhe ("O que faz", "Para quem é"...). */
    public function descricoes(): HasMany
    {
        return $this->hasMany(DescricaoProjeto::class)->orderBy('id');
    }

    public function rotulo(): string
    {
        return self::ESTAGIOS[$this->estagio]['rotulo'] ?? $this->estagio;
    }

    public function classe(): string
    {
        return self::ESTAGIOS[$this->estagio]['classe'] ?? '';
    }

    /** Chave do ícone do cartão (cai no genérico se estiver vazia ou não existir). */
    public function iconeChave(): string
    {
        return array_key_exists((string) $this->icone, self::ICONES) ? $this->icone : 'padrao';
    }

    /** Endereço da página de detalhe (/projetos/{slug}). */
    public function url(): string
    {
        return route('projetos.show', $this->slug);
    }

    /** Endereço do botão da página de detalhe (se o destino não existir mais, vai para Contato). */
    public function linkUrl(): string
    {
        return route(array_key_exists($this->link_destino, self::DESTINOS) ? $this->link_destino : 'contato');
    }
}
