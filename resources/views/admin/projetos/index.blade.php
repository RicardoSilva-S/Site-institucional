@extends('layouts.admin')

@section('title', 'Projetos')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Projetos</p>
      <h1>Projetos e soluções</h1>
      <p class="admin-muted">Cartões do portfólio da página <a href="{{ route('projetos') }}#projetos" target="_blank" rel="noopener">Projetos ↗</a>. Os textos em volta (título da seção, introdução, chamada final) ficam em "Páginas do site → Projetos".</p>
    </div>
    <a href="{{ route('admin.projetos.create') }}" class="btn btn-primary btn-sm">+ Novo projeto</a>
  </div>

  @if ($projetos->isEmpty())
    <div class="admin-empty">
      <p>Nenhum projeto cadastrado. Enquanto a lista estiver vazia, o portfólio aparece sem cartões.</p>
    </div>
  @else
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Projeto</th>
            <th>Situação</th>
            <th>Ordem</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($projetos as $projeto)
            <tr>
              <td>
                <strong>{{ $projeto->titulo }}</strong>
                @if ($projeto->categorias)<br><span class="admin-muted">{{ $projeto->categorias }}</span>@endif
              </td>
              <td>
                <span class="admin-badge{{ $projeto->estagio === 'implementado' ? '' : ' admin-badge--muted' }}">{{ $projeto->rotulo() }}</span>
              </td>
              <td>{{ $projeto->ordem }}</td>
              <td class="admin-table__actions">
                <a href="{{ route('admin.projetos.edit', $projeto) }}" class="btn-text">Editar</a>
                <form method="POST" action="{{ route('admin.projetos.destroy', $projeto) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-text btn-text--danger" data-confirm="Excluir este projeto?">Excluir</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endsection
