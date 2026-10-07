@extends('layouts.admin')

@section('title', 'Banners')

@section('content')
  <div class="admin-page-head">
    <div>
      <p class="admin-eyebrow">Mídia</p>
      <h1>Banners</h1>
      <p class="admin-muted">Imagens do carrossel no topo das páginas e das imagens ao lado das seções (ex: frentes da página Atuação). Com mais de um banner no mesmo lugar, eles passam em carrossel.</p>
    </div>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm">+ Novo banner</a>
  </div>

  @if ($banners->isEmpty())
    <div class="admin-empty">
      <p>Nenhum banner cadastrado ainda. Enquanto não houver banners, o topo das páginas continua como está hoje e as seções mostram a imagem padrão.</p>
    </div>
  @else
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Imagem</th>
            <th>Título</th>
            <th>Onde aparece</th>
            <th>Ordem</th>
            <th>Situação</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($banners as $banner)
            <tr>
              <td><img src="{{ $banner->imageUrl() }}" alt="" class="admin-thumb"></td>
              <td>
                <strong>{{ $banner->title ?: '(sem título)' }}</strong>
                @if ($banner->subtitle)<br><span class="admin-muted">{{ \Illuminate\Support\Str::limit($banner->subtitle, 70) }}</span>@endif
              </td>
              <td>{{ \App\Support\BannerSlots::label($banner->page, $banner->slot) }}</td>
              <td>{{ $banner->sort_order }}</td>
              <td>
                <span class="admin-badge{{ $banner->active ? '' : ' admin-badge--muted' }}">{{ $banner->active ? 'Ativo' : 'Inativo' }}</span>
              </td>
              <td class="admin-table__actions">
                <a href="{{ route('admin.banners.edit', $banner) }}" class="btn-text">Editar</a>
                <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-text btn-text--danger" data-confirm="Excluir este banner?">Excluir</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endsection
