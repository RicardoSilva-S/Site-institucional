@extends('layouts.admin')

@section('title', 'Marcos da linha do tempo')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Institucional</p>
      <h1>Marcos da linha do tempo</h1>
      <p class="admin-muted">Passos da seção "Nossa história" da página <a href="{{ route('institucional') }}#linha-do-tempo" target="_blank" rel="noopener">Institucional ↗</a>. Aparecem na ordem abaixo; o último fica destacado como o mais recente.</p>
    </div>
    <a href="{{ route('admin.marcos.create') }}" class="btn btn-primary btn-sm">+ Novo marco</a>
  </div>

  @if ($marcos->isEmpty())
    <div class="admin-empty">
      <p>Nenhum marco cadastrado. Enquanto estiver vazio, a linha do tempo não aparece no site.</p>
    </div>
  @else
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Data</th>
            <th>Texto</th>
            <th>Ordem</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($marcos as $marco)
            <tr>
              <td><strong>{{ $marco->data }}</strong></td>
              <td>{{ \Illuminate\Support\Str::limit($marco->texto, 90) }}</td>
              <td>{{ $marco->ordem }}</td>
              <td class="admin-table__actions">
                <a href="{{ route('admin.marcos.edit', $marco) }}" class="btn-text">Editar</a>
                <form method="POST" action="{{ route('admin.marcos.destroy', $marco) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-text btn-text--danger" data-confirm="Remover o marco {{ $marco->data }} do site?">Remover</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endsection