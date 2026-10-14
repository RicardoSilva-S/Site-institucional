@extends('layouts.app')

@section('title', 'Hub de tecnologia para a administração pública | IDTNPR')
@section('description', 'O IDTNPR é uma instituição de ciência e tecnologia sem fins lucrativos que reúne soluções tecnológicas para prefeituras e câmaras municipais e indica o caminho jurídico para contratá-las.')

@section('content')

  <!-- HERO -->
  <section class="hero">
    <div class="wrap hero-grid">
      <div>
        <span class="eyebrow"><span class="dot" aria-hidden="true"></span> <span>@content('home.hero.eyebrow')</span></span>
        <h1>@content('home.hero.title')</h1>
        <p class="lead">@content('home.hero.lead')</p>
        <div class="cta-row">
          <a href="{{ route('contato') }}#diagnostico" class="btn btn-primary">@content('home.hero.cta1')</a>
          <a href="{{ route('projetos') }}" class="btn btn-outline">@content('home.hero.cta2')</a>
        </div>

        <ul class="facts">
          <li>@content('home.hero.fact1')</li>
          <li>@content('home.hero.fact2')</li>
          <li>@content('home.hero.fact3')</li>
          <li>@content('home.hero.fact4')</li>
        </ul>
      </div>

      <div class="catalog-card">
        <span class="tag">@content('home.catalog.tag')</span>
        <h3>@content('home.catalog.title')</h3>
        <ul class="catalog-list">
          @for ($i = 1; $i <= 6; $i++)
            <x-catalog-item :prefix="'home.catalog.item'.$i" />
          @endfor
        </ul>
      </div>
    </div>
    @extraTexts('home.hero')

    @extraTexts('home.catalog')
  </section>

  <!-- O PROBLEMA -->
  <section>
    <div class="wrap">
      <div class="problem-grid">
        <div>
          <span class="section-head kicker" style="display:block;">@content('home.problem.kicker')</span>
          <h2 style="margin-bottom:18px;">@content('home.problem.title')</h2>
          <p>@content('home.problem.text')</p>

          <details class="readmore">
            <summary>Continuar lendo</summary>
            <div class="more">
              <p>@content('home.problem.more1')</p>
              <p style="margin-top:14px;">@content('home.problem.more2')</p>
              <a class="link" href="{{ route('marco-legal') }}">@content('home.problem.link')</a>
            </div>
          </details>
        </div>

        <div class="compare">
          <div class="compare-row head">
            <div class="compare-cell bad-head">@content('home.compare.head.left')</div>
            <div class="compare-cell good-head">@content('home.compare.head.right')</div>
          </div>
          @for ($i = 1; $i <= 4; $i++)
            <x-compare-row :prefix="'home.compare.row'.$i" />
          @endfor
        </div>
      </div>
    </div>
    @extraTexts('home.problem')

    @extraTexts('home.compare')
  </section>

  <!-- COMO FUNCIONA -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('home.steps.kicker')</span>
        <h2>@content('home.steps.title')</h2>
        <p class="sub">@content('home.steps.sub')</p>
      </div>
      {{-- Carrossel das etapas: setas ao lado (public/js/site.js) e cartões
           sempre inteiros na tela (4 no computador, 2 no tablet, 1 no celular).
           role="region" faz o aria-label ser anunciado por leitores de tela. --}}
      <div class="steps-carousel">
        <button type="button" class="steps-nav steps-nav--prev" aria-label="Etapa anterior">‹</button>
        <div class="steps-track" role="region" tabindex="0" aria-label="Etapas do processo">
          @for ($i = 1; $i <= 5; $i++)
            <x-step :num="$i" :prefix="'home.step'.$i" />
          @endfor
        </div>
        <button type="button" class="steps-nav steps-nav--next" aria-label="Próxima etapa">›</button>
      </div>
    </div>
    @extraTexts('home.steps')
  </section>

  <!-- COMO ATUAMOS -->
  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('home.cards.kicker')</span>
        <h2>@content('home.cards.title')</h2>
        <p class="sub">@content('home.cards.sub')</p>
      </div>

      <div class="cards-grid">
        @for ($i = 1; $i <= 6; $i++)
          <x-card :prefix="'home.card'.$i" />
        @endfor
      </div>

      <p class="cards-note">@content('home.cards.note')</p>
      <div class="cards-cta">
        <a href="{{ route('projetos') }}">@content('home.cards.cta1')</a>
        <a href="{{ route('atuacao') }}">@content('home.cards.cta2')</a>
      </div>
    </div>
    @extraTexts('home.cards')
  </section>

  <!-- POR QUE PELO INSTITUTO -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('home.stats.kicker')</span>
        <h2>@content('home.stats.title')</h2>
      </div>

      <div class="stats-grid">
        @for ($i = 1; $i <= 4; $i++)
          <x-stat :prefix="'home.stat'.$i" />
        @endfor
      </div>

      <div class="rite-strip">
        @for ($i = 1; $i <= 5; $i++)
          <x-rite-stage :prefix="'home.rite'.$i" />
        @endfor
      </div>

      <div class="stats-copy">
        <p>@content('home.stats.copy1')</p>
        <p>@content('home.stats.copy2')</p>
      </div>

      <div style="margin-top:32px;">
        <a href="{{ route('marco-legal') }}" class="btn btn-outline">@content('home.stats.cta')</a>
      </div>
    </div>
    @extraTexts('home.stats')
  </section>

  <!-- TRANSPARÊNCIA -->
  <section>
    <div class="wrap transp-grid">
      <div>
        <span class="section-head kicker" style="display:block;">@content('home.transp.kicker')</span>
        <h2 style="margin-bottom:16px;">@content('home.transp.title')</h2>
        <p style="color:var(--ink-soft);font-size:16.5px;">@content('home.transp.text')</p>
        <a href="{{ route('transparencia') }}" class="btn btn-primary" style="margin-top:26px;">@content('home.transp.cta')</a>
      </div>
      <div class="transp-items">
        @for ($i = 1; $i <= 4; $i++)
          <x-transp-item :prefix="'home.transp.item'.$i" />
        @endfor
      </div>
    </div>
    @extraTexts('home.transp')
  </section>

  <!-- CTA FINAL -->
  <section class="final-cta">
    <div class="wrap">
      <div>
        <h2>@content('home.finalcta.title')</h2>
        <p>@content('home.finalcta.text')</p>
      </div>
      <a href="{{ route('contato') }}" class="btn btn-gold">@content('home.finalcta.button')</a>
    </div>
    @extraTexts('home.finalcta')
  </section>

@endsection
