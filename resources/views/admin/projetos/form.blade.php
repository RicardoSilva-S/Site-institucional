@extends('layouts.admin')

@section('title', $projeto->exists ? 'Editar projeto' : 'Novo projeto')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow"><a href="{{ route('admin.projetos.index') }}">← Projetos</a></p>
      <h1>{{ $projeto->exists ? 'Editar projeto' : 'Novo projeto' }}</h1>
    </div>
  </div>

  <form method="POST" class="admin-card admin-form"
        action="{{ $projeto->exists ? route('admin.projetos.update', $projeto) : route('admin.projetos.store') }}">
    @csrf
    @if ($projeto->exists)
      @method('PUT')
    @endif

    <div class="admin-form__row">
      <label for="titulo">Nome do projeto</label>
      <input type="text" id="titulo" name="titulo" maxlength="255" required value="{{ old('titulo', $projeto->titulo) }}" placeholder="Ex: Totem de Autoatendimento">
    </div>

    <div class="admin-form__row">
      <label for="estagio">Situação</label>
      <select id="estagio" name="estagio">
        @foreach ($estagios as $valor => $info)
          <option value="{{ $valor }}" @if (old('estagio', $projeto->estagio) === $valor) selected @endif>{{ $info['rotulo'] }}</option>
        @endforeach
      </select>
    </div>

    <div class="admin-form__row">
      <label for="categorias">Frente (opcional)</label>
      <input type="text" id="categorias" name="categorias" maxlength="255" value="{{ old('categorias', $projeto->categorias) }}" placeholder="Ex: Atendimento ao cidadão">
    </div>

    <div class="admin-form__row">
      <label for="breve_descricao">Descrição</label>
      <div>
        <textarea id="breve_descricao" name="breve_descricao" rows="3" maxlength="500" required>{{ old('breve_descricao', $projeto->breve_descricao) }}</textarea>
        <small class="admin-muted">O que o projeto resolve, em uma ou duas frases.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="tecnologia">Tecnologia (opcional)</label>
      <textarea id="tecnologia" name="tecnologia" rows="2" maxlength="500" placeholder="Ex: autoatendimento digital, interface acessível...">{{ old('tecnologia', $projeto->tecnologia) }}</textarea>
    </div>

    <div class="admin-form__row">
      <label for="link_rotulo">Texto do link (opcional)</label>
      <div>
        <input type="text" id="link_rotulo" name="link_rotulo" maxlength="255" value="{{ old('link_rotulo', $projeto->link_rotulo) }}" placeholder="Ex: Conhecer a solução">
        <small class="admin-muted">Deixe vazio para o cartão não ter link.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="link_destino">O link leva para</label>
      <select id="link_destino" name="link_destino">
        @foreach ($destinos as $rota => $rotulo)
          <option value="{{ $rota }}" @if (old('link_destino', $projeto->link_destino) === $rota) selected @endif>{{ $rotulo }}</option>
        @endforeach
      </select>
    </div>

    <div class="admin-form__row">
      <label for="ordem">Ordem</label>
      <div>
        <input type="number" id="ordem" name="ordem" min="0" value="{{ old('ordem', $projeto->ordem) }}">
        <small class="admin-muted">Número menor aparece primeiro.</small>
      </div>
    </div>

    <div class="admin-form__actions">
      <a href="{{ route('admin.projetos.index') }}" class="btn-text">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-sm">Salvar projeto</button>
    </div>
  </form>
@endsection
