@extends('layouts.admin')

@section('title', $banner->exists ? 'Editar banner' : 'Novo banner')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow"><a href="{{ route('admin.banners.index') }}">← Banners</a></p>
      <h1>{{ $banner->exists ? 'Editar banner' : 'Novo banner' }}</h1>
    </div>
  </div>

  <form method="POST" enctype="multipart/form-data" class="admin-card admin-form"
        action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}">
    @csrf
    @if ($banner->exists)
      @method('PUT')
    @endif

    <div class="admin-form__row">
      <label for="image">Imagem {{ $banner->exists ? '(envie outra para trocar)' : '' }}</label>
      <div>
        @if ($banner->exists)
          <img src="{{ $banner->imageUrl() }}" alt="" class="admin-preview" id="image-preview">
        @else
          <img src="" alt="" class="admin-preview" id="image-preview" hidden>
        @endif
        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" @unless($banner->exists) required @endunless>
        <small class="admin-muted">JPG, PNG ou WEBP, até 4 MB. Tamanho recomendado: 1920 × 600 px.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="page">Página</label>
      <select id="page" name="page">
        <option value="">Todas as páginas</option>
        @foreach ($pages as $route => $label)
          <option value="{{ $route }}" @if (old('page', $banner->page) === $route) selected @endif>{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <div class="admin-form__row">
      <label for="title">Título</label>
      <input type="text" id="title" name="title" maxlength="255" value="{{ old('title', $banner->title) }}">
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
      <a href="{{ route('admin.banners.index') }}" class="btn-text">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-sm">Salvar banner</button>
    </div>
  </form>
@endsection