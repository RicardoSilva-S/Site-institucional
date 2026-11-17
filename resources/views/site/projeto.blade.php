@extends('layouts.app')

@section('title', $projeto->titulo . ' | Projetos e produtos | IDTNPR')
@section('description', $projeto->breve_descricao)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/projetos.css') }}">
@endpush

{{--
  Página de detalhe de um projeto (/projetos/{slug}).

  Dados ($projeto, App\Models\Projeto, vindo de SiteController@projeto):
    titulo, categorias, breve_descricao, problema, tecnologia,
    rotulo()/classe() (selo), iconeChave(), link_rotulo + linkUrl() (botão)
    descricoes -> blocos { titulo, texto } da tabela descricao_projetos
--}}

@section('content')

  <section class="projetos-hero projetos-hero--detalhe">
    <div class="wrap">
      <nav class="projetos-trilha" aria-label="Você está em">
        <a href="{{ route('projetos') }}">Projetos e produtos</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">{{ $projeto->titulo }}</span>
      </nav>

      <div class="projeto-detalhe__head">
        <span class="projeto-card__icone projeto-card__icone--grande">
          <x-projeto-icone :nome="$projeto->iconeChave()" />
        </span>
        <div>
          <h1>{{ $projeto->titulo }}</h1>
          <p class="projeto-detalhe__meta">
            @if ($projeto->categorias)<span>{{ $projeto->categorias }}</span>@endif
            <span class="status {{ $projeto->classe() }}">{{ $projeto->rotulo() }}</span>
          </p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap projeto-detalhe">
      <div class="projeto-detalhe__texto">
        <p class="projeto-detalhe__lead">{{ $projeto->breve_descricao }}</p>

        @if ($projeto->problema)
          <h2>O problema</h2>
          <p>{!! nl2br(e($projeto->problema)) !!}</p>
        @endif

        @foreach ($projeto->descricoes as $bloco)
          <h2>{{ $bloco->titulo }}</h2>
          <p>{!! nl2br(e($bloco->texto)) !!}</p>
        @endforeach

        @if ($projeto->tecnologia)
          <h2>Tecnologia</h2>
          <p>{{ $projeto->tecnologia }}</p>
        @endif
      </div>

      <aside class="projeto-detalhe__aside" aria-label="Como contratar">
        <h2>Como contratar</h2>
        <p>Antes da proposta, o Instituto indica por qual instrumento legal a solução pode ser contratada no seu município e entrega a fundamentação à Procuradoria.</p>
        <div class="projeto-detalhe__acoes">
          @if ($projeto->link_rotulo)
            <a href="{{ $projeto->linkUrl() }}" class="btn btn-primary">{{ $projeto->link_rotulo }}</a>
          @endif
          <a href="{{ route('marco-legal') }}" class="btn btn-outline">Ver os instrumentos disponíveis</a>
        </div>
      </aside>
    </div>

    <div class="wrap">
      <a href="{{ route('projetos') }}#catalogo" class="projetos-voltar"><span aria-hidden="true">←</span> Voltar ao catálogo</a>
    </div>
  </section>

@endsection
