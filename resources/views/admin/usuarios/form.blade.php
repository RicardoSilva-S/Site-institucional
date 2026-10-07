@extends('layouts.admin')

@section('title', $usuario->exists ? 'Editar usuário' : 'Novo usuário')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow"><a href="{{ route('admin.usuarios.index') }}">← Usuários</a></p>
      <h1>{{ $usuario->exists ? 'Editar usuário' : 'Novo usuário' }}</h1>
    </div>
  </div>

  <form method="POST" class="admin-card admin-form"
        action="{{ $usuario->exists ? route('admin.usuarios.update', $usuario) : route('admin.usuarios.store') }}">
    @csrf
    @if ($usuario->exists)
      @method('PUT')
    @endif

    <div class="admin-form__row">
      <label for="name">Nome</label>
      <input type="text" id="name" name="name" maxlength="255" required value="{{ old('name', $usuario->name) }}">
    </div>

    <div class="admin-form__row">
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" maxlength="255" required value="{{ old('email', $usuario->email) }}">
    </div>

    <div class="admin-form__row">
      <label for="papel">Papel</label>
      <select id="papel" name="papel">
        @foreach (\App\Models\User::PAPEIS as $valor => $nome)
          <option value="{{ $valor }}" @if (old('papel', $usuario->papel) === $valor) selected @endif>{{ $nome }}</option>
        @endforeach
      </select>
    </div>

    <div class="admin-form__row">
      <label for="password">Senha {{ $usuario->exists ? '(deixe em branco para manter)' : '' }}</label>
      <input type="password" id="password" name="password" minlength="8" autocomplete="new-password" @unless($usuario->exists) required @endunless>
    </div>

    <div class="admin-form__row">
      <label for="password_confirmation">Confirmar senha</label>
      <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" autocomplete="new-password">
    </div>

    <div class="admin-form__row">
      <span></span>
      <label class="admin-check">
        <input type="checkbox" name="ativo" value="1" @if (old('ativo', $usuario->ativo)) checked @endif>
        Usuário ativo (pode entrar no painel)
      </label>
    </div>

    <div class="admin-form__actions">
      <a href="{{ route('admin.usuarios.index') }}" class="btn-text">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-sm">Salvar usuário</button>
    </div>
  </form>
@endsection
