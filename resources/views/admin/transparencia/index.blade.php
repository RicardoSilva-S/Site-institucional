@extends('layouts.admin')

@section('title', 'Transparência')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Transparência</p>
      <h1>Documentos do Portal da Transparência</h1>
      <p class="admin-muted">Seções e documentos da página <a href="{{ route('transparencia') }}" target="_blank" rel="noopener">Transparência ↗</a>. Documento com PDF aparece com o botão "Baixar PDF"; sem PDF, aparece "Solicitar" (pelo WhatsApp) ou a situação dele.</p>
    </div>
    <div class="admin-table__actions">
      <a href="{{ route('admin.transparencia.secoes.create') }}" class="btn btn-outline btn-sm">+ Nova seção</a>
      @if ($secoes->isNotEmpty())
        <a href="{{ route('admin.transparencia.documentos.create') }}" class="btn btn-primary btn-sm">+ Novo documento</a>
      @endif
    </div>
  </div>

  @if ($secoes->isEmpty())
    <div class="admin-empty">
      <p>Nenhuma seção cadastrada ainda. Crie uma seção (ex: Institucional) e depois adicione os documentos dela.</p>
    </div>
  @endif

  @foreach ($secoes as $secao)
    <div class="admin-page-head" id="secao-{{ $secao->id }}" style="margin-top:32px;">
      <div>
        <h2>{{ $secao->titulo }}</h2>
        @if ($secao->subtitulo)<p class="admin-muted">{{ $secao->subtitulo }}</p>@endif
      </div>
      <div class="admin-table__actions">
        <a href="{{ route('admin.transparencia.documentos.create', ['secao' => $secao->id]) }}" class="btn-text">+ Documento</a>
        <a href="{{ route('admin.transparencia.secoes.edit', $secao) }}" class="btn-text">Editar seção</a>
        <form method="POST" action="{{ route('admin.transparencia.secoes.destroy', $secao) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn-text btn-text--danger"
                  data-confirm="Excluir a seção &quot;{{ $secao->titulo }}&quot; e os {{ $secao->documentos->count() }} documento(s) dela?">Excluir seção</button>
        </form>
      </div>
    </div>

    @if ($secao->documentos->isEmpty())
      <div class="admin-empty">
        <p>Nenhum documento nesta seção. Enquanto ela estiver vazia, não aparece no site.</p>
      </div>
    @else
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Documento</th>
              <th>Situação</th>
              <th>PDF</th>
              <th>Ordem</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($secao->documentos as $documento)
              <tr>
                <td>
                  <strong>{{ $documento->nome }}</strong>
                  @if ($documento->detalhe)<br><span class="admin-muted">{{ $documento->detalhe }}</span>@endif
                </td>
                <td>
                  <span class="admin-badge{{ $documento->status === 'publicado' ? '' : ' admin-badge--muted' }}">{{ \App\Models\TransparenciaDocumento::STATUS[$documento->status] ?? $documento->status }}</span>
                </td>
                <td>
                  @if ($documento->temArquivo())
                    <a href="{{ route('transparencia.documento', $documento) }}" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::limit($documento->arquivo_nome, 30) }}</a>
                  @else
                    <span class="admin-muted">—</span>
                  @endif
                </td>
                <td>{{ $documento->ordem }}</td>
                <td class="admin-table__actions">
                  <a href="{{ route('admin.transparencia.documentos.edit', $documento) }}" class="btn-text">Editar</a>
                  <form method="POST" action="{{ route('admin.transparencia.documentos.destroy', $documento) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-text btn-text--danger" data-confirm="Excluir este documento?">Excluir</button>
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
