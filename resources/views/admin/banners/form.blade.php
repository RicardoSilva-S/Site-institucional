@extends('layouts.admin')

@section('title', $banner->exists ? 'Editar banner' : 'Novo banner')

@php
  $posicaoAtual = old('posicao', \App\Support\BannerSlots::encode($banner->page, $banner->slot));
  $voltarUrl = $voltar ? route('admin.pages.show', $voltar).($banner->slot ? '#secao-'.$banner->slot : '') : route('admin.banners.index');
@endphp

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow"><a href="{{ $voltarUrl }}">← {{ $voltar ? 'Voltar para a página' : 'Banners' }}</a></p>
      <h1>{{ $banner->exists ? 'Editar banner' : 'Novo banner' }}</h1>
    </div>
  </div>

  <form method="POST" enctype="multipart/form-data" class="admin-card admin-form"
        action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}">
    @csrf
    @if ($banner->exists)
      @method('PUT')
    @endif
    @if ($voltar)
      <input type="hidden" name="voltar" value="{{ $voltar }}">
    @endif

    {{-- Onde o banner aparece: carrossel do topo (de uma página ou de todas)
         ou ao lado de uma seção. Cada opção traz o tamanho recomendado. --}}
    <div class="admin-form__row">
      <label for="posicao">Onde aparece</label>
      <div>
        <select id="posicao" name="posicao">
          @foreach ($positions as $pageLabel => $options)
            <optgroup label="{{ $pageLabel }}">
              @foreach ($options as $value => $label)
                @php $isSection = \Illuminate\Support\Str::contains($value, \App\Support\BannerSlots::SEPARATOR); @endphp
                <option value="{{ $value }}"
                        data-section="{{ $isSection ? '1' : '0' }}"
                        data-hint="{{ $isSection ? 'JPG, PNG ou WEBP, até 4 MB. Tamanho recomendado: 1200 × 900 px (proporção 4:3).' : 'JPG, PNG ou WEBP, até 4 MB. Tamanho recomendado: 1920 × 600 px.' }}"
                        @if ((string) $posicaoAtual === (string) $value) selected @endif>{{ $label }}</option>
              @endforeach
            </optgroup>
          @endforeach
        </select>
        <small class="admin-muted">Imagens de seção substituem a ilustração padrão daquela seção. Com mais de um banner ativo no mesmo lugar, eles passam em carrossel.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="image">Imagem {{ $banner->exists ? '(envie outra para trocar)' : '' }}</label>
      <div>
        @if ($banner->exists)
          <img src="{{ $banner->imageUrl() }}" alt="" class="admin-preview{{ $banner->slot ? ' admin-preview--section' : '' }}" id="image-preview">
        @else
          <img src="" alt="" class="admin-preview{{ $banner->slot ? ' admin-preview--section' : '' }}" id="image-preview" hidden>
        @endif
        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" @unless($banner->exists) required @endunless>
        <small class="admin-muted" id="image-hint">JPG, PNG ou WEBP, até 4 MB.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="title">Título</label>
      <div>
        <input type="text" id="title" name="title" maxlength="255" value="{{ old('title', $banner->title) }}">
        <small class="admin-muted">Também é lido por leitores de tela como descrição da imagem.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="subtitle">Subtítulo</label>
      <textarea id="subtitle" name="subtitle" rows="2" maxlength="500">{{ old('subtitle', $banner->subtitle) }}</textarea>
    </div>

    <div class="admin-form__row">
      <label for="link">Link (opcional)</label>
      <input type="text" id="link" name="link" maxlength="255" placeholder="Ex: /contato ou https://..." value="{{ old('link', $banner->link) }}">
    </div>

    <div class="admin-form__row">
      <label for="sort_order">Ordem</label>
      <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $banner->sort_order) }}">
    </div>

    <div class="admin-form__row">
      <span></span>
      <label class="admin-check">
        <input type="checkbox" name="active" value="1" @if (old('active', $banner->active)) checked @endif>
        Banner ativo (aparece no site)
      </label>
    </div>

    <div class="admin-form__actions">
      <a href="{{ $voltarUrl }}" class="btn-text">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-sm">Salvar banner</button>
    </div>
  </form>
@endsection
