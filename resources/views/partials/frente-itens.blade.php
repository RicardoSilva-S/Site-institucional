{{-- Itens de uma frente (página Atuação), em colunas separadas por um fio.
     Uso:
       @include('partials.frente-itens', ['prefix' => 'atuacao.governanca.item', 'count' => 4])
     Cada item N tem as keys "{prefix}N.title" e "{prefix}N.text". O texto
     aparece como frase solta (SiteContent::sentence). Itens excluídos no
     painel (título e texto vazios) somem. --}}
@php
  $items = collect(range(1, $count))
      ->map(fn ($i) => [
          'title' => \App\Support\SiteContent::text("{$prefix}{$i}.title"),
          'text' => \App\Support\SiteContent::sentence("{$prefix}{$i}.text"),
      ])
      ->filter(fn ($item) => trim($item['title']) !== '' || trim($item['text']) !== '');
@endphp
@if ($items->isNotEmpty())
  <ul class="frente-itens{{ $items->count() % 3 === 0 ? ' frente-itens--3' : '' }}">
    @foreach ($items as $item)
      <li>
        <h3>{{ $item['title'] }}</h3>
        <p>{{ $item['text'] }}</p>
      </li>
    @endforeach
  </ul>
@endif
