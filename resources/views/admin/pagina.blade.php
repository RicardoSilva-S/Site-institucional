@extends('layouts.admin')

@section('title', $page['pageLabel'])

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Textos da página</p>
      <h1>{{ $page['pageLabel'] }}</h1>
    </div>
    @if (!empty($page['route']))
      <a href="{{ route($page['route']) }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">Ver página ↗</a>
    @endif
  </div>

  <input type="search" id="admin-search" class="admin-search" placeholder="Buscar um texto nesta página…">

  {{-- Formulário principal: salva todos os textos da página de uma vez.
       Os botões "Excluir"/"Restaurar" ficam em forms separados (no fim da
       página) e são ligados pelo atributo form="...", porque um <form> não
       pode ficar dentro de outro. --}}
  <form id="admin-form" method="POST" action="{{ route('admin.pages.update', $page['page']) }}">
    @csrf
    @method('PUT')

    @foreach ($groups as $group)
      <section class="admin-group" id="secao-{{ $group['id'] }}">
        <h2>{{ $group['label'] }}</h2>

        @forelse ($group['texts'] as $text)
          @php $isEmpty = trim((string) $text->value) === ''; @endphp
          <div class="admin-field{{ $isEmpty ? ' is-empty' : '' }}{{ $text->custom ? ' is-custom' : '' }}">
            <label for="text-{{ $text->id }}">
              {{ $text->label }}
              @if ($text->custom)
                <span class="admin-badge">inserido</span>
              @elseif ($isEmpty)
                <span class="admin-badge admin-badge--muted">excluído do site</span>
              @endif
            </label>

            <div>
              @if ($text->long)
                <textarea id="text-{{ $text->id }}" name="texts[{{ $text->id }}]" rows="3"
                          placeholder="{{ $defaults[$text->key] ?? '' }}">{{ old('texts.'.$text->id, $text->value) }}</textarea>
              @else
                <input type="text" id="text-{{ $text->id }}" name="texts[{{ $text->id }}]"
                       placeholder="{{ $defaults[$text->key] ?? '' }}" value="{{ old('texts.'.$text->id, $text->value) }}">
              @endif

              <div class="admin-field__actions">
                @if (!$text->custom && ($defaults[$text->key] ?? null) !== null && $text->value !== $defaults[$text->key])
                  <button type="submit" form="restore-{{ $text->id }}" class="btn-text">Restaurar original</button>
                @endif
                @unless ($isEmpty && !$text->custom)
                  <button type="submit" form="delete-{{ $text->id }}" class="btn-text btn-text--danger" data-confirm="Excluir este texto do site?">Excluir</button>
                @endunless
              </div>
            </div>
          </div>
        @empty
          <p class="admin-muted">Nenhum texto nesta seção.</p>
        @endforelse

        @if ($group['canAdd'])
          <details class="admin-add">
            <summary>+ Adicionar texto nesta seção</summary>
            <div class="admin-add__body">
              <p class="admin-muted">O texto novo aparece no site no fim da seção "{{ $group['label'] }}".</p>
              <label>Nome (só aparece no painel)
                <input type="text" name="label" form="add-{{ $group['id'] }}" maxlength="120" placeholder="Ex: Parágrafo extra" required>
              </label>
              <label>Texto
                <textarea name="value" form="add-{{ $group['id'] }}" rows="3" required></textarea>
              </label>
              <button type="submit" form="add-{{ $group['id'] }}" class="btn btn-outline btn-sm">Adicionar texto</button>
            </div>
          </details>
        @endif
      </section>
    @endforeach

    <div class="admin-save-bar">
      <p>As alterações valem para todos os visitantes assim que forem salvas.</p>
      <button type="submit" class="btn btn-primary btn-sm">Salvar alterações</button>
    </div>
  </form>

  {{-- Forms auxiliares (fora do form principal) --}}
  @foreach ($groups as $group)
    @if ($group['canAdd'])
      <form id="add-{{ $group['id'] }}" method="POST" action="{{ route('admin.texts.store', $page['page']) }}" hidden>
        @csrf
        <input type="hidden" name="group" value="{{ $group['id'] }}">
      </form>
    @endif
    @foreach ($group['texts'] as $text)
      <form id="delete-{{ $text->id }}" method="POST" action="{{ route('admin.texts.destroy', $text) }}" hidden>
        @csrf
        @method('DELETE')
      </form>
      @unless ($text->custom)
        <form id="restore-{{ $text->id }}" method="POST" action="{{ route('admin.texts.restore', $text) }}" hidden>
          @csrf
        </form>
      @endunless
    @endforeach
  @endforeach
@endsection