@extends('layouts.admin')

@section('title', 'Diretoria e conselho')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Institucional</p>
      <h1>Diretoria e conselho</h1>
      <p class="admin-muted">Pessoas da seção "Governança" da página <a href="{{ route('institucional') }}#governanca" target="_blank" rel="noopener">Institucional ↗</a>. A diretoria aparece em cartões com foto; o conselho, em lista com as iniciais do nome.</p>
    </div>
    <a href="{{ route('admin.equipe.create') }}" class="btn btn-primary btn-sm">+ Nova pessoa</a>
  </div>

  @foreach ($grupos as $grupo => $dados)
    <div class="admin-page-head" style="margin-top:32px;">
      <h2>{{ $dados['rotulo'] }}</h2>
      <a href="{{ route('admin.equipe.create', ['grupo' => $grupo]) }}" class="btn-text">+ Adicionar</a>
    </div>

    @if ($dados['membros']->isEmpty())
      <div class="admin-empty">
        <p>Ninguém cadastrado. Enquanto estiver vazio, esta parte não mostra nenhuma pessoa no site.</p>
      </div>
    @else
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Foto</th>
              <th>Nome</th>
              <th>Cargo</th>
              <th>Ordem</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($dados['membros'] as $membro)
              <tr>
                <td>
                  @if ($membro->temFoto())
                    <img src="{{ $membro->fotoUrl() }}" alt="" class="admin-thumb">
                  @else
                    <span class="admin-muted">{{ $membro->sigla() }}</span>
                  @endif
                </td>
                <td><strong>{{ $membro->nome }}</strong></td>
                <td>{{ $membro->cargo }}</td>
                <td>{{ $membro->ordem }}</td>
                <td class="admin-table__actions">
                  <a href="{{ route('admin.equipe.edit', $membro) }}" class="btn-text">Editar</a>
                  <form method="POST" action="{{ route('admin.equipe.destroy', $membro) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-text btn-text--danger" data-confirm="Remover {{ $membro->nome }} do site?">Remover</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  @endforeach
@endsection
