@extends('layouts.admin')

@section('title', 'Backup do banco')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Acesso</p>
      <h1>Backup do banco</h1>
      <p class="admin-muted">Cópia de todos os dados do site: textos, banners, transparência, equipe, editais, mensagens, ouvidoria e usuários. Funciona em MySQL e Postgres, então também serve para mudar o site de hospedagem.</p>
    </div>
  </div>

  <div class="admin-card admin-form">
    <h2>Baixar backup</h2>
    <p class="admin-muted">Gera agora um arquivo <code>.ndjson.gz</code> com {{ count($tabelas) }} tabelas. Guarde fora do servidor (ex: Google Drive).</p>
    <div class="admin-form__actions">
      <a href="{{ route('admin.backup.baixar') }}" class="btn btn-primary btn-sm">Baixar backup agora</a>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.backup.restaurar') }}" enctype="multipart/form-data" class="admin-card admin-form">
    @csrf
    <h2>Restaurar backup</h2>
    <p class="admin-muted"><strong>Atenção:</strong> apaga os dados atuais e coloca os do arquivo no lugar, inclusive os usuários do painel (talvez seja preciso entrar de novo). Se der erro no meio, nada é alterado.</p>

    <div class="admin-form__row">
      <label for="arquivo">Arquivo de backup</label>
      <input type="file" id="arquivo" name="arquivo" accept=".gz" required>
    </div>

    <div class="admin-form__row">
      <label for="confirmacao">Digite <strong>RESTAURAR</strong> para confirmar</label>
      <input type="text" id="confirmacao" name="confirmacao" autocomplete="off" required>
    </div>

    <div class="admin-form__actions">
      <button type="submit" class="btn btn-primary btn-sm">Restaurar</button>
    </div>
  </form>
@endsection
