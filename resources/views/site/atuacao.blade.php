@extends('layouts.app')

@section('title', 'Atuação | IDTNPR')
@section('description', 'Conheça as frentes de atuação do IDTNPR para modernizar a gestão pública, estruturar políticas de inovação e apoiar municípios com soluções tecnológicas.')

{{-- Cada frente: título e texto ao lado da imagem da seção
     (partials/section-banner, editável em /adm/banners ou no editor da página)
     e, embaixo, os itens em colunas (partials/frente-itens) ou a nota. --}}
@section('content')
  <section class="page-hero page-hero--split">
    <div class="wrap">
      <div>
        <span class="eyebrow"><span class="dot"></span> @content('atuacao.hero.eyebrow')</span>
        <h1>@content('atuacao.hero.title')</h1>
        <p class="lead">@content('atuacao.hero.lead')</p>
        @if (\App\Support\SiteContent::has('atuacao.hero.cta'))
          <div class="cta-row">
            <a href="{{ route('contato') }}" class="btn btn-primary">@content('atuacao.hero.cta')</a>
          </div>
        @endif
      </div>
      @include('partials.section-banner', ['slot' => 'hero', 'eager' => true])
    </div>
    @extraTexts('atuacao.hero')
  </section>

  <nav class="frentes-nav" aria-label="Frentes de atuação">
    <div class="wrap">
      <ul>
        <li><a href="#governanca-publica">@content('atuacao.nav.governanca')</a></li>
        <li><a href="#observatorio">@content('atuacao.nav.observatorio')</a></li>
        <li><a href="#pmo">@content('atuacao.nav.pmo')</a></li>
        <li><a href="#marco-legal-inovacao">@content('atuacao.nav.marcolegal')</a></li>
        <li><a href="#capacitacao">@content('atuacao.nav.capacitacao')</a></li>
        <li><a href="#piloto">@content('atuacao.nav.piloto')</a></li>
      </ul>
    </div>
  </nav>

  <section class="frente-section" id="governanca-publica">
    <div class="wrap frente">
      <div class="frente__top">
        <div class="frente__text">
          <div class="section-head">
            <span class="kicker">@content('atuacao.governanca.kicker')</span>
            <h2>@content('atuacao.governanca.title')</h2>
            <p class="sub">@content('atuacao.governanca.sub')</p>
          </div>
          @if (\App\Support\SiteContent::has('atuacao.governanca.text'))
            <div class="frente__intro"><p>@content('atuacao.governanca.text')</p></div>
          @endif
        </div>
        <div class="frente__media">
          @include('partials.section-banner', ['slot' => 'governanca'])
        </div>
      </div>
      <div class="frente__items">
        @include('partials.frente-itens', ['prefix' => 'atuacao.governanca.item', 'count' => 4])
      </div>
    </div>
    @extraTexts('atuacao.governanca')
  </section>

  <section class="alt frente-section" id="observatorio">
    <div class="wrap frente">
      <div class="frente__top">
        <div class="frente__text">
          <div class="section-head">
            <span class="kicker">@content('atuacao.observatorio.kicker')</span>
            <h2>@content('atuacao.observatorio.title')</h2>
            <p class="sub">@content('atuacao.observatorio.sub')</p>
          </div>
          @if (\App\Support\SiteContent::has('atuacao.observatorio.text'))
            <div class="frente__intro"><p>@content('atuacao.observatorio.text')</p></div>
          @endif
        </div>
        <div class="frente__media">
          @include('partials.section-banner', ['slot' => 'observatorio'])
        </div>
      </div>
      <div class="frente__items">
        @include('partials.frente-itens', ['prefix' => 'atuacao.observatorio.item', 'count' => 4])
      </div>
    </div>
    @extraTexts('atuacao.observatorio')
  </section>

  <section class="frente-section" id="pmo">
    <div class="wrap frente">
      <div class="frente__top">
        <div class="frente__text">
          <div class="section-head">
            <span class="kicker">@content('atuacao.pmo.kicker')</span>
            <h2>@content('atuacao.pmo.title')</h2>
            <p class="sub">@content('atuacao.pmo.sub')</p>
          </div>
          <div class="frente__intro">
            <h3>@content('atuacao.pmo.question')</h3>
            <p>@content('atuacao.pmo.answer') <em>@content('atuacao.pmo.answer.highlight')</em>@content('atuacao.pmo.answer.end')</p>
          </div>
        </div>
        <div class="frente__media">
          @include('partials.section-banner', ['slot' => 'pmo'])
        </div>
      </div>
      <div class="frente__items">
        <div class="legal-note">
          <h3>@content('atuacao.pmo.note.title')</h3>
          <p>@content('atuacao.pmo.note.text')</p>
        </div>
      </div>
    </div>
    @extraTexts('atuacao.pmo')
  </section>

  <section class="alt frente-section" id="marco-legal-inovacao">
    <div class="wrap frente">
      <div class="frente__top">
        <div class="frente__text">
          <div class="section-head">
            <span class="kicker">@content('atuacao.marcolegal.kicker')</span>
            <h2>@content('atuacao.marcolegal.title')</h2>
            <p class="sub">@content('atuacao.marcolegal.sub')</p>
          </div>
          @if (\App\Support\SiteContent::has('atuacao.marcolegal.text'))
            <div class="frente__intro"><p>@content('atuacao.marcolegal.text')</p></div>
          @endif
        </div>
        <div class="frente__media">
          @include('partials.section-banner', ['slot' => 'marcolegal'])
        </div>
      </div>
      <div class="frente__items">
        @include('partials.frente-itens', ['prefix' => 'atuacao.marcolegal.item', 'count' => 4])
        <p class="cards-note">@content('atuacao.marcolegal.note.start') <strong>@content('atuacao.marcolegal.note.highlight')</strong>@content('atuacao.marcolegal.note.end')</p>
      </div>
    </div>
    @extraTexts('atuacao.marcolegal')
  </section>

  <section class="frente-section" id="capacitacao">
    <div class="wrap frente">
      <div class="frente__top">
        <div class="frente__text">
          <div class="section-head">
            <span class="kicker">@content('atuacao.capacitacao.kicker')</span>
            <h2>@content('atuacao.capacitacao.title')</h2>
            <p class="sub">@content('atuacao.capacitacao.sub')</p>
          </div>
        </div>
        <div class="frente__media">
          @include('partials.section-banner', ['slot' => 'capacitacao'])
        </div>
      </div>
      <div class="frente__items">
        @include('partials.frente-itens', ['prefix' => 'atuacao.capacitacao.card', 'count' => 6])
      </div>
    </div>
    @extraTexts('atuacao.capacitacao')
  </section>

  <section class="alt frente-section" id="piloto">
    <div class="wrap frente">
      <div class="frente__top">
        <div class="frente__text">
          <div class="section-head">
            <span class="kicker">@content('atuacao.piloto.kicker')</span>
            <h2>@content('atuacao.piloto.title')</h2>
            <p class="sub">@content('atuacao.piloto.sub')</p>
          </div>
          @if (\App\Support\SiteContent::has('atuacao.piloto.text'))
            <div class="frente__intro"><p>@content('atuacao.piloto.text')</p></div>
          @endif
        </div>
        <div class="frente__media">
          @include('partials.section-banner', ['slot' => 'piloto'])
        </div>
      </div>
      <div class="frente__items">
        <div class="legal-note">
          <h3>@content('atuacao.piloto.note.title')</h3>
          <p><strong>@content('atuacao.piloto.note.highlight')</strong> @content('atuacao.piloto.note.text')</p>
        </div>
      </div>
    </div>
    @extraTexts('atuacao.piloto')
  </section>

  <section class="final-cta">
    <div class="wrap">
      <div>
        <h2>@content('atuacao.cta.title')</h2>
        <p>@content('atuacao.cta.text')</p>
      </div>
      <a href="{{ route('contato') }}" class="btn btn-gold">@content('atuacao.cta.btn')</a>
    </div>
    @extraTexts('atuacao.cta')
  </section>
@endsection

@push('scripts')
  <script src="{{ asset('js/secoes-nav.js') }}"></script>
@endpush
