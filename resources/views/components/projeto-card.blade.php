{{-- Cartão de um projeto do catálogo (página /projetos).
     Uso: <x-projeto-card :projeto="$projeto" />

     Espera um App\Models\Projeto (ou qualquer objeto com os mesmos campos e
     métodos): titulo, categorias, breve_descricao, rotulo(), classe(),
     iconeChave() e url(). Estilos em public/css/projetos.css.

     O cartão inteiro é clicável: o "Ver detalhes" estica a área de clique
     sobre o cartão (.projeto-card__link::after), sem aninhar links. --}}
@props(['projeto'])

<article {{ $attributes->merge(['class' => 'projeto-card']) }}>
  <div class="projeto-card__head">
    <span class="projeto-card__icone">
      <x-projeto-icone :nome="$projeto->iconeChave()" />
    </span>
    <div>
      <h3 class="projeto-card__titulo">{{ $projeto->titulo }}</h3>
      @if ($projeto->categorias)
        <p class="projeto-card__categoria">{{ $projeto->categorias }}</p>
      @endif
    </div>
  </div>

  <p class="projeto-card__descricao">{{ $projeto->breve_descricao }}</p>

  <div class="projeto-card__rodape">
    <span class="status {{ $projeto->classe() }}">{{ $projeto->rotulo() }}</span>
    <a href="{{ $projeto->url() }}" class="projeto-card__link">
      Ver detalhes<span class="visually-hidden"> de {{ $projeto->titulo }}</span>
      <span aria-hidden="true">→</span>
    </a>
  </div>
</article>
