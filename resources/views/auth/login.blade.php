<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Entrar | Painel IDTNPR</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="auth-shell">
  <div class="auth-card">
    <img src="{{ asset('assets/logo.png') }}" alt="IDTNPR">
    <h1>Entrar no painel</h1>
    <p class="sub">Acesse para editar os textos do site.</p>

    @if ($errors->any())
      <div class="admin-flash error">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}">
      @csrf

      <div class="auth-field">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
      </div>

      <div class="auth-field">
        <label for="password">Senha</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">
      </div>

      <button type="submit" class="btn btn-primary">Entrar</button>
    </form>

    <a href="{{ route('home') }}" class="auth-back">← Voltar para o site</a>
  </div>
</div>

</body>
</html>
