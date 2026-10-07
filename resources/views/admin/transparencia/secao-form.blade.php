@extends('layouts.admin')

@section('title', $secao->exists ? 'Editar seção' : 'Nova seção')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow"><a href="{{ route('admin.transparencia.index') }}">← Transparência</a></p>
      <h1>{{ $secao->exists ? 'Editar seção' : 'Nova seção' }}</h1>
    </div>
  </div>

  <form method="POST" class="admin-card admin-form"
        action="{{ $secao->exists ? route('admin.transparencia.secoes.update', $secao) : route('admin.transparencia.secoes.store') }}">
    @csrf
    @if ($secao->exists)
      @method('PUT')
    @endif

    <div class="admin-form__row">
      <label for="titulo">Título</label>
      <input type="text" id="titulo" name="titulo" maxlength="255" required value="{{ old('titulo', $secao->titulo) }}" placeholder="Ex: Prestação de contas">
    </div>

    <div class="admin-form__row">
      <label for="subtitulo">Subtítulo</label>
      <input type="text" id="subtitulo" name="subtitulo" maxlength="255" value="{{ old('subtitulo', $secao->subtitulo) }}" placeholder="Ex: Demonstrativos e pareceres">
    </div>

    <div class="admin-form__row">
      <label for="ordem">Ordem</label>
      <div>
        <input type="number" id="ordem" name="ordem" min="0" value="{{ old('ordem', $secao->ordem) }}">
        <small class="admin-muted">Número menor aparece primeiro na página.</small>
      </div>
    </div>

    <div class="admin-form__actions">
      <a href="{{ route('admin.transparencia.index') }}" class="btn-text">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-sm">Salvar seção</button>
    </div>
  </form>
@endsection
