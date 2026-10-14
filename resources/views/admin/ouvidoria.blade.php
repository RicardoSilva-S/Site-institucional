@extends('layouts.admin')

@section('title', 'Ouvidoria')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Contato</p>
      <h1>Ouvidoria</h1>
      <p class="admin-muted">
        Manifestações enviadas pelo formulário da ouvidoria, da mais recente para a mais antiga.
        @if ($pendentes > 0)
          <strong>{{ $pendentes }} aguardando resposta.</strong>
        @else
          Todas as manifestações estão respondidas.
        @endif
      </p>
    </div>
  </div>

  <div class="admin-messages">
    @forelse ($manifestacoes as $manifestacao)
      <article class="msg-card {{ $manifestacao->estaRespondida() ? 'is-read' : 'is-unread' }}">
        <header class="msg-head">
          <div>
            <h3>{{ $manifestacao->protocolo() }} · {{ $manifestacao->nomeDoTipo() }}
              @unless ($manifestacao->estaRespondida()) <span class="msg-badge">nova</span> @endunless
            </h3>
            <p class="msg-meta">
              {{ $manifestacao->anonimo ? 'Anônima' : $manifestacao->nome }}
              · {{ $manifestacao->created_at->format('d/m/Y H:i') }}
            </p>
          </div>
          <form method="POST" action="{{ route('admin.ouvidoria.status', $manifestacao) }}">
            @csrf
            <button type="submit" class="btn btn-outline btn-sm">
              {{ $manifestacao->estaRespondida() ? 'Marcar como não respondida' : 'Marcar como respondida' }}
            </button>
          </form>
        </header>

        @unless ($manifestacao->anonimo)
          <dl class="msg-fields">
            @if ($manifestacao->email)
              <dt>E-mail</dt><dd><a href="mailto:{{ $manifestacao->email }}">{{ $manifestacao->email }}</a></dd>
            @endif
            @if ($manifestacao->telefone)
              <dt>Telefone</dt><dd>{{ $manifestacao->telefone }}</dd>
            @endif
          </dl>
        @endunless

        <p class="msg-body">{!! nl2br(e($manifestacao->mensagem)) !!}</p>
      </article>
    @empty
      <div class="msg-empty">Nenhuma manifestação recebida ainda.</div>
    @endforelse

    <div class="msg-pager">{{ $manifestacoes->links('pagination::simple-default') }}</div>
  </div>
@endsection
