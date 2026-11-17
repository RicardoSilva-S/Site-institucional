@extends('layouts.app')

@section('title', 'Projetos e produtos | IDTNPR')
@section('description', 'Catálogo de soluções que o IDTNPR desenvolve e reúne para prefeituras, câmaras e autarquias, cada uma com o instrumento jurídico que viabiliza a contratação.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/projetos.css') }}">
@endpush

{{--
  Página /projetos, no formato do modelo antigo (idtnpr.org.br/projetos.html).

  Dados:
    $projetos -> coleção de App\Models\Projeto (SiteController@projetos),
                 cadastrados no painel em /adm/projetos.
  Textos: @content('projetos.*'), definidos em config/site_content.php e
  editáveis em "Páginas do site → Projetos".
--}}

@section('content')

  {{-- TOPO --}}
  <section class="projetos-hero">
    <div class="wrap">
      <h1>@content('projetos.hero.title')</h1>
      <p class="lead">@content('projetos.hero.lead')</p>
    </div>
    @extraTexts('projetos.hero')
  </section>

  {{-- O CATÁLOGO --}}
  <section id="catalogo" class="scroll-offset">
    <div class="wrap">
      <div class="section-head projetos-head">
        <span class="kicker">@content('projetos.portfolio.kicker')</span>
        <h2>@content('projetos.portfolio.title')</h2>
        <p class="sub">
          @content('projetos.portfolio.sub')
          @content('projetos.portfolio.hint')
        </p>
      </div>

      @if ($projetos->isEmpty())
        <p class="projetos-vazio">Nenhuma solução publicada no momento.</p>
      @else
        <div class="projetos-grid">
          @foreach ($projetos as $projeto)
            <x-projeto-card :projeto="$projeto" />
          @endforeach
        </div>
      @endif
    </div>
    @extraTexts('projetos.portfolio')
  </section>

  {{-- COMO CHEGA AO MUNICÍPIO --}}
  <section class="alt">
    <div class="wrap">
      <div class="section-head projetos-head">
        <span class="kicker">@content('projetos.caminho.kicker')</span>
        <h2>@content('projetos.caminho.title')</h2>
        <p class="sub">@content('projetos.caminho.text1')</p>
        <p class="projetos-nota">@content('projetos.caminho.text2')</p>
      </div>
      <div class="cta-row projetos-acoes">
        <a href="{{ route('marco-legal') }}" class="btn btn-primary">@content('projetos.caminho.btn1')</a>
        <a href="{{ route('contato') }}#diagnostico" class="btn btn-outline">@content('projetos.caminho.btn2')</a>
      </div>
    </div>
    @extraTexts('projetos.caminho')
  </section>

  {{-- CHAMADA PARA PARCEIROS --}}
  <section class="final-cta projetos-cta">
    <div class="wrap">
      <h2>@content('projetos.cta.title')</h2>
      <p>@content('projetos.cta.text')</p>
      <a href="{{ route('editais') }}#parceria" class="btn btn-gold">@content('projetos.cta.btn')</a>
    </div>
    @extraTexts('projetos.cta')
  </section>

@endsection
