Nova mensagem recebida pelo formulário de contato do site.

Nome: {!! $contact->nome !!}
@if ($contact->cargo)
Cargo/função: {!! $contact->cargo !!}
@endif
Órgão/município: {!! $contact->orgao !!}
@if ($contact->email)
E-mail: {!! $contact->email !!}
@endif
@if ($contact->telefone)
Telefone: {!! $contact->telefone !!}
@endif
@if ($contact->area)
Área do problema: {!! $contact->area !!}
@endif

Descrição:
{!! $contact->mensagem !!}

--
Ver todas as mensagens: {{ route('admin.messages.index') }}
