@extends('layouts.admin')

@section('title', $edital->exists ? 'Editar edital' : 'Novo edital')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow"><a href="{{ route('admin.editais.index') }}">← Editais</a></p>
      <h1>{{ $edital->exists ? 'Editar edital' : 'Novo edital' }}</h1>
    </div>
  </div>

  <form method="POST" enctype="multipart/form-data" class="admin-card admin-form"
        action="{{ $edital->exists ? route('admin.editais.update', $edital) : route('admin.editais.store') }}">
    @csrf
    @if ($edital->exists)
      @method('PUT')
    @endif

    <div class="admin-form__row">
      <label for="titulo">Título</label>
      <input type="text" id="titulo" name="titulo" maxlength="255" required value="{{ old('titulo', $edital->titulo) }}" placeholder="Ex: Chamamento Público nº 005/2026 – ...">
    </div>

    <div class="admin-form__row">
      <label for="resumo">Resumo</label>
      <div>
        <textarea id="resumo" name="resumo" rows="3" maxlength="2000">{{ old('resumo', $edital->resumo) }}</textarea>
        <small class="admin-muted">O objeto do edital em uma ou duas frases.</small>
      </div>
    </div>

    <div class="admin-form__row">
      <label for="status">Situação</label>
      <select id="status" name="status">
        @foreach ($status as $valor => $info)
          <option value="{{ $valor }}" @if (old('status', $edital->status) === $valor) selected @endif>{{ $info['rotulo'] }}</option>
        @endforeach
      </select>
    </div>

    <div class="admin-form__row">
      <label for="abertura">Abertura</label>
      <input type="date" id="abertura" name="abertura" value="{{ old('abertura', optional($edital->abertura)->format('Y-m-d')) }}">
    </div>

    <div class="admin-form__row">
      <label for="encerramento">Encerramento</label>
      <input type="date" id="encerramento" name="encerramento" value="{{ old('encerramento', optional($edital->encerramento)->format('Y-m-d')) }}">
    </div>

    <div class="admin-form__row">
      <label for="arquivo">PDF do edital {{ $edital->temArquivo() ? '(envie outro para trocar)' : '(opcional)' }}</label>
      <div>
        @if ($edital->temArquivo())
          <p>
            Arquivo atual:
            <a href="{{ route('editais.pdf', $edital) }}" target="_blank" rel="noopener">{{ $edital->arquivo_nome }}</a>
          </p>
        @endif
        <input type="file" id="arquivo" name="arquivo" accept="application/pdf,.pdf">
        <small class="admin-muted">Somente PDF, até {{ $tamanhoMaximoMb }} MB. No site, o botão aparece como "Baixar edital" (ou "Acessar resultado", se o edital estiver encerrado). Sem PDF, o edital aparece sem botão.</small>
        @if ($edital->temArquivo())
          <label class="admin-check">
            <input type="checkbox" name="remover_arquivo" value="1">
            Remover o PDF atual
          </label>
        @endif
      </div>
    </div>

    <div class="admin-form__actions">
      <a href="{{ route('admin.editais.index') }}" class="btn-text">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-sm">Salvar edital</button>
    </div>
  </form>
@endsection
