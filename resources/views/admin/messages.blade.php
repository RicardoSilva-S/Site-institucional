@extends('layouts.admin')

@section('title', 'Mensagens')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Contato</p>
      <h1>Mensagens recebidas</h1>
      <p class="admin-muted">
        Mensagens enviadas pelo formulário do site, da mais recente para a mais antiga.
        @if ($unread > 0)
          <strong>{{ $unread }} {{ $unread === 1 ? 'não lida' : 'não lidas' }}.</strong>
        @else
          Todas as mensagens estão marcadas como lidas.
        @endif
      </p>
    </div>
  </div>

  <div class="admin-messages">
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
@endsection
