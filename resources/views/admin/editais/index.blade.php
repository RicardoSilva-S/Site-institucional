@extends('layouts.admin')

@section('title', 'Editais')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Editais</p>
      <h1>Editais e chamamentos</h1>
      <p class="admin-muted">Lista da página <a href="{{ route('editais') }}#lista-editais" target="_blank" rel="noopener">Editais ↗</a>. Os números do "Quadro de avisos" (abertos, em análise, encerrados) são calculados a partir desta lista. Edital sem PDF aparece no site sem o botão de baixar.</p>
    </div>
    <a href="{{ route('admin.editais.create') }}" class="btn btn-primary btn-sm">+ Novo edital</a>
  </div>

  @if ($editais->isEmpty())
    <div class="admin-empty">
      <p>Nenhum edital cadastrado. Enquanto a lista estiver vazia, a página mostra a mensagem de "nenhum edital encontrado".</p>
    </div>
  @else
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Edital</th>
            <th>Situação</th>
            <th>Abertura</th>
            <th>Encerramento</th>
            <th>PDF</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($editais as $edital)
            <tr>
              <td><strong>{{ \Illuminate\Support\Str::limit($edital->titulo, 90) }}</strong></td>
              <td>
                <span class="admin-badge{{ $edital->status === 'aberto' ? '' : ' admin-badge--muted' }}">{{ $edital->rotulo() }}</span>
              </td>
              <td>{{ optional($edital->abertura)->format('d/m/Y') ?: '—' }}</td>
              <td>{{ optional($edital->encerramento)->format('d/m/Y') ?: '—' }}</td>
              <td>
                @if ($edital->temArquivo())
                  <a href="{{ route('editais.pdf', $edital) }}" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::limit($edital->arquivo_nome, 25) }}</a>
                @else
                  <span class="admin-muted">sem PDF</span>
                @endif
              </td>
              <td class="admin-table__actions">
                <a href="{{ route('admin.editais.edit', $edital) }}" class="btn-text">Editar</a>
                <form method="POST" action="{{ route('admin.editais.destroy', $edital) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-text btn-text--danger" data-confirm="Excluir este edital?">Excluir</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endsection
