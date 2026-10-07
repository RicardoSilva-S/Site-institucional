@extends('layouts.admin')

@section('title', 'Usuários')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Acesso</p>
      <h1>Usuários</h1>
      <p class="admin-muted">Quem pode entrar no painel. O administrador gerencia usuários; o editor só altera textos e banners.</p>
    </div>
    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary btn-sm">+ Novo usuário</a>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Papel</th>
          <th>Último login</th>
          <th>Situação</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($usuarios as $usuario)
          <tr>
            <td><strong>{{ $usuario->name }}</strong></td>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->nomeDoPapel() }}</td>
            <td>{{ $usuario->ultimo_login ? $usuario->ultimo_login->format('d/m/Y H:i') : 'Nunca entrou' }}</td>
            <td>
              <span class="admin-badge{{ $usuario->ativo ? '' : ' admin-badge--muted' }}">{{ $usuario->ativo ? 'Ativo' : 'Inativo' }}</span>
            </td>
            <td class="admin-table__actions">
              <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn-text">Editar</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
