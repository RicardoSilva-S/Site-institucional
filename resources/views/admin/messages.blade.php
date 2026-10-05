<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mensagens recebidas | IDTNPR</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-shell">

  <header class="admin-header">
    <div class="wrap">
      <div class="brand-row">
        <img src="{{ asset('assets/logo.png') }}" alt="IDTNPR">
        <h1>Mensagens recebidas</h1>
      </div>
      <div style="display:flex;align-items:center;gap:18px;flex-wrap:wrap;">
        <a class="back-link" href="{{ route('admin.content.edit') }}">Editar textos</a>
        <a class="back-link" href="{{ route('home') }}">← Voltar para o site</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-text" style="color:rgba(255,255,255,0.75);">Sair ({{ auth()->user()->email }})</button>
        </form>
      </div>
    </div>
  </header>

  <div class="wrap admin-intro">
    <h2>Formulário de contato</h2>
    <p>
      Mensagens enviadas pelo site, da mais recente para a mais antiga.
      @if ($unread > 0)
        <strong>{{ $unread }} {{ $unread === 1 ? 'não lida' : 'não lidas' }}.</strong>
      @else
        Todas as mensagens estão marcadas como lidas.
      @endif
    </p>
  </div>

  <div class="wrap admin-messages">
    @forelse ($messages as $message)
      <article class="msg-card {{ $message->isRead() ? 'is-read' : 'is-unread' }}">
        <header class="msg-head">
          <div>
            <h3>{{ $message->nome }}
              @unless ($message->isRead()) <span class="msg-badge">nova</span> @endunless
            </h3>
            <p class="msg-meta">
              {{ $message->orgao }}@if ($message->cargo) · {{ $message->cargo }}@endif
              · {{ $message->created_at->format('d/m/Y H:i') }}
            </p>
          </div>
          <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}">
            @csrf
            <button type="submit" class="btn btn-outline btn-sm">
              {{ $message->isRead() ? 'Marcar como não lida' : 'Marcar como lida' }}
            </button>
          </form>
        </header>

        <dl class="msg-fields">
          @if ($message->email)
            <dt>E-mail</dt><dd><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>
          @endif
          @if ($message->telefone)
            <dt>Telefone</dt><dd>{{ $message->telefone }}</dd>
          @endif
          @if ($message->area)
            <dt>Área</dt><dd>{{ $message->area }}</dd>
          @endif
        </dl>

        <p class="msg-body">{!! nl2br(e($message->mensagem)) !!}</p>
      </article>
    @empty
      <div class="msg-empty">Nenhuma mensagem recebida ainda.</div>
    @endforelse

    <div class="msg-pager">{{ $messages->links('pagination::simple-default') }}</div>
  </div>

</body>
</html>
