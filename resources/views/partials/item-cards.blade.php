{{-- Itens de uma frente em cartões numerados (página Atuação). Uso:
       @include('partials.item-cards', ['prefix' => 'atuacao.governanca.item', 'count' => 4])
     Cada item N tem as keys "{prefix}N.title" e "{prefix}N.text". O texto
     aparece como frase solta (SiteContent::sentence). Itens excluídos no
     painel (título e texto vazios) somem e a numeração se ajusta. --}}
@php
  $items = collect(range(1, $count))
      ->map(fn ($i) => [
          'title' => \App\Support\SiteContent::text("{$prefix}{$i}.title"),
          'text' => \App\Support\SiteContent::sentence("{$prefix}{$i}.text"),
      ])
      ->filter(fn ($item) => trim($item['title']) !== '' || trim($item['text']) !== '')
      ->values();
@endphp
@if ($items->isNotEmpty())
  <div class="item-cards{{ $items->count() % 3 === 0 ? ' item-cards--3' : '' }}">
    @foreach ($items as $item)
      <article class="item-card">
        <span class="num">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
        <h3>{{ $item['title'] }}</h3>
        <p>{{ $item['text'] }}</p>
      </article>
    @endforeach
  </div>
@endif
