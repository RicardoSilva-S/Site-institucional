@extends('layouts.admin')

@section('title', $documento->exists ? 'Editar documento' : 'Novo documento')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow"><a href="{{ route('admin.transparencia.index') }}">← Transparência</a></p>
      <h1>{{ $documento->exists ? 'Editar documento' : 'Novo documento' }}</h1>
    </div>
  </div>

  <form method="POST" enctype="multipart/form-data" class="admin-card admin-form"
        action="{{ $documento->exists ? route('admin.transparencia.documentos.update', $documento) : route('admin.transparencia.documentos.store') }}">
    @csrf
    @if ($documento->exists)
      @method('PUT')
    @endif

    <div class="admin-form__row">
      <label for="secao_id">Seção</label>
      <select id="secao_id" name="secao_id" required>
        <option value="">Escolha a seção</option>
        @foreach ($secoes as $secao)
          <option value="{{ $secao->id }}" @if ((string) old('secao_id', $documento->secao_id) === (string) $secao->id) selected @endif>{{ $secao->titulo }}</option>
        @endforeach
      </select>
    </div>

    <div class="admin-form__row">
      <label for="nome">Nome do documento</label>
      <input type="text" id="nome" name="nome" maxlength="255" required value="{{ old('nome', $documento->nome) }}" placeholder="Ex: Estatuto Social consolidado">
    </div>

    <div class="admin-form__row">
      <label for="detalhe">Detalhe (opcional)</label>
      <div>
        <input type="text" id="detalhe" name="detalhe" maxlength="255" value="{{ old('detalhe', $documento->detalhe) }}" placeholder="Ex: 02/01/2026 · Registro nº 508/01">
        <small class="admin-muted">Aparece em letra menor, abaixo do nome.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="status">Situação</label>
      <div>
        <select id="status" name="status">
          @foreach ($status as $valor => $rotulo)
            <option value="{{ $valor }}" @if (old('status', $documento->status) === $valor) selected @endif>{{ $rotulo }}</option>
          @endforeach
        </select>
        <small class="admin-muted">Com PDF, o site mostra "Baixar PDF". Sem PDF: "Disponível" mostra o botão "Solicitar"; as outras mostram a situação.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="arquivo">PDF {{ $documento->temArquivo() ? '(envie outro para trocar)' : '(opcional)' }}</label>
      <div>
        @if ($documento->temArquivo())
          <p>
            Arquivo atual:
            <a href="{{ route('transparencia.documento', $documento) }}" target="_blank" rel="noopener">{{ $documento->arquivo_nome }}</a>
          </p>
        @endif
        <input type="file" id="arquivo" name="arquivo" accept="application/pdf,.pdf">
        <small class="admin-muted">Somente PDF, até {{ $tamanhoMaximoMb }} MB.</small>
        @if ($documento->temArquivo())
          <label class="admin-check">
            <input type="checkbox" name="remover_arquivo" value="1">
            Remover o PDF atual (o documento continua na lista, sem o botão de baixar)
          </label>
        @endif
      </div>
    </div>

    <div class="admin-form__row">
      <label for="ordem">Ordem</label>
      <div>
        <input type="number" id="ordem" name="ordem" min="0" value="{{ old('ordem', $documento->ordem) }}">
        <small class="admin-muted">Número menor aparece primeiro dentro da seção.</small>
      </div>
    </div>

    <div class="admin-form__actions">
      <a href="{{ route('admin.transparencia.index') }}" class="btn-text">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-sm">Salvar documento</button>
    </div>
  </form>
@endsection
