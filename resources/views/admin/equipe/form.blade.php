@extends('layouts.admin')

@section('title', $membro->exists ? 'Editar pessoa' : 'Nova pessoa')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow"><a href="{{ route('admin.equipe.index') }}">← Diretoria e conselho</a></p>
      <h1>{{ $membro->exists ? 'Editar ' . $membro->nome : 'Nova pessoa' }}</h1>
    </div>
  </div>

  <form method="POST" enctype="multipart/form-data" class="admin-card admin-form"
        action="{{ $membro->exists ? route('admin.equipe.update', $membro) : route('admin.equipe.store') }}">
    @csrf
    @if ($membro->exists)
      @method('PUT')
    @endif

    <div class="admin-form__row">
      <label for="grupo">Onde aparece</label>
      <select id="grupo" name="grupo">
        @foreach ($grupos as $valor => $rotulo)
          <option value="{{ $valor }}" @if (old('grupo', $membro->grupo) === $valor) selected @endif>{{ $rotulo }}</option>
        @endforeach
      </select>
    </div>

    <div class="admin-form__row">
      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" maxlength="255" required value="{{ old('nome', $membro->nome) }}">
    </div>

    <div class="admin-form__row">
      <label for="cargo">Cargo</label>
      <input type="text" id="cargo" name="cargo" maxlength="255" required value="{{ old('cargo', $membro->cargo) }}" placeholder="Ex: Diretoria administrativa">
    </div>

    <div class="admin-form__row">
      <label for="bio">Texto do cartão</label>
      <div>
        <textarea id="bio" name="bio" rows="3" maxlength="1000">{{ old('bio', $membro->bio) }}</textarea>
        <small class="admin-muted">Formação e experiência, em uma ou duas frases. Aparece só nos cartões da diretoria.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="foto">Foto {{ $membro->temFoto() ? '(envie outra para trocar)' : '(opcional)' }}</label>
      <div>
        @if ($membro->temFoto())
          <img src="{{ $membro->fotoUrl() }}" alt="" class="admin-preview admin-preview--section">
        @endif
        <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp">
        <small class="admin-muted">JPG, PNG ou WEBP, até 4 MB. Usada nos cartões da diretoria (o conselho mostra as iniciais do nome).</small>
        <label class="admin-check">
          <input type="checkbox" name="foto_aproximada" value="1" @if (old('foto_aproximada', $membro->foto_aproximada)) checked @endif>
          Aproximar a foto (amplia um pouco, para o rosto ficar maior no cartão)
        </label>
        @if ($membro->temFoto())
          <label class="admin-check">
            <input type="checkbox" name="remover_foto" value="1">
            Remover a foto atual
          </label>
        @endif
      </div>
    </div>

    <div class="admin-form__row">
      <label for="ordem">Ordem</label>
      <div>
        <input type="number" id="ordem" name="ordem" min="0" value="{{ old('ordem', $membro->ordem) }}">
        <small class="admin-muted">Número menor aparece primeiro.</small>
      </div>
    </div>

    <div class="admin-form__actions">
      <a href="{{ route('admin.equipe.index') }}" class="btn-text">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
    </div>
  </form>
@endsection
