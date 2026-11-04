@extends('layouts.admin')

@section('title', $marco->exists ? 'Editar marco' : 'Novo marco')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow"><a href="{{ route('admin.marcos.index') }}">← Marcos da linha do tempo</a></p>
      <h1>{{ $marco->exists ? 'Editar marco ' . $marco->data : 'Novo marco' }}</h1>
    </div>
  </div>

  <form method="POST" class="admin-card admin-form"
        action="{{ $marco->exists ? route('admin.marcos.update', $marco) : route('admin.marcos.store') }}">
    @csrf
    @if ($marco->exists)
      @method('PUT')
    @endif

    <div class="admin-form__row">
      <label for="data">Data</label>
      <div>
        <input type="text" id="data" name="data" maxlength="40" required value="{{ old('data', $marco->data) }}" placeholder="Ex: Jul · 2025">
        <small class="admin-muted">Do jeito que deve aparecer no site, em cima do texto.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="texto">Texto</label>
      <div>
        <textarea id="texto" name="texto" rows="3" maxlength="500" required>{{ old('texto', $marco->texto) }}</textarea>
        <small class="admin-muted">O que aconteceu, em uma ou duas frases.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="ordem">Ordem</label>
      <div>
        <input type="number" id="ordem" name="ordem" min="0" value="{{ old('ordem', $marco->ordem) }}">
        <small class="admin-muted">Número menor aparece primeiro. Use a ordem cronológica: o último marco fica destacado como o mais recente.</small>
      </div>
    </div>

    <div class="admin-form__actions">
      <a href="{{ route('admin.marcos.index') }}" class="btn-text">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
    </div>
  </form>
@endsection