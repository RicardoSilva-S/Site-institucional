@extends('layouts.app')

@section('title', 'Hub de tecnologia para a administração pública | IDTNPR')
@section('description', 'O IDTNPR é uma instituição de ciência e tecnologia sem fins lucrativos que reúne soluções tecnológicas para prefeituras e câmaras municipais e indica o caminho jurídico para contratá-las.')

@section('content')

  <!-- HERO -->
  <section class="hero">
    <div class="wrap hero-grid">
      <div>
        <span class="eyebrow"><span class="dot"></span> <span>@content('home.hero.eyebrow')</span></span>
        <h1>@content('home.hero.title')</h1>
        <p class="lead">@content('home.hero.lead')</p>
        <div class="cta-row">
          <a href="#" class="btn btn-primary">@content('home.hero.cta1')</a>
          <a href="#" class="btn btn-outline">@content('home.hero.cta2')</a>
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
          <li><span class="item-left"><span class="item-dot"></span><span class="item-label">@content('home.catalog.item1.label')</span></span><span class="item-cat">@content('home.catalog.item1.cat')</span></li>
          <li><span class="item-left"><span class="item-dot"></span><span class="item-label">@content('home.catalog.item2.label')</span></span><span class="item-cat">@content('home.catalog.item2.cat')</span></li>
          <li><span class="item-left"><span class="item-dot"></span><span class="item-label">@content('home.catalog.item3.label')</span></span><span class="item-cat">@content('home.catalog.item3.cat')</span></li>
          <li><span class="item-left"><span class="item-dot"></span><span class="item-label">@content('home.catalog.item4.label')</span></span><span class="item-cat">@content('home.catalog.item4.cat')</span></li>
          <li><span class="item-left"><span class="item-dot"></span><span class="item-label">@content('home.catalog.item5.label')</span></span><span class="item-cat">@content('home.catalog.item5.cat')</span></li>
          <li><span class="item-left"><span class="item-dot"></span><span class="item-label">@content('home.catalog.item6.label')</span></span><span class="item-cat">@content('home.catalog.item6.cat')</span></li>
        </ul>
      </div>
    </div>
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
          <div class="compare-row">
            <div class="compare-cell bad"><span class="icon">✕</span><span>@content('home.compare.row1.bad')</span></div>
            <div class="compare-cell good"><span class="icon">✓</span><span>@content('home.compare.row1.good')</span></div>
          </div>
          <div class="compare-row">
            <div class="compare-cell bad"><span class="icon">✕</span><span>@content('home.compare.row2.bad')</span></div>
            <div class="compare-cell good"><span class="icon">✓</span><span>@content('home.compare.row2.good')</span></div>
          </div>
          <div class="compare-row">
            <div class="compare-cell bad"><span class="icon">✕</span><span>@content('home.compare.row3.bad')</span></div>
            <div class="compare-cell good"><span class="icon">✓</span><span>@content('home.compare.row3.good')</span></div>
          </div>
          <div class="compare-row">
            <div class="compare-cell bad"><span class="icon">✕</span><span>@content('home.compare.row4.bad')</span></div>
            <div class="compare-cell good"><span class="icon">✓</span><span>@content('home.compare.row4.good')</span></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- COMO FUNCIONA -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('home.steps.kicker')</span>
        <h2>@content('home.steps.title')</h2>
        <p class="sub">@content('home.steps.sub')</p>
      </div>
      <p class="steps-hint">@content('home.steps.hint')</p>
      <div class="steps-track">
        <div class="step">
          <span class="num">1</span>
          <h3>@content('home.step1.title')</h3>
          <p>@content('home.step1.desc')</p>
          <span class="free">@content('home.step1.free')</span>
        </div>
        <div class="step">
          <span class="num">2</span>
          <h3>@content('home.step2.title')</h3>
          <p>@content('home.step2.desc')</p>
          <span class="free">@content('home.step2.free')</span>
        </div>
        <div class="step">
          <span class="num">3</span>
          <h3>@content('home.step3.title')</h3>
          <p>@content('home.step3.desc')</p>
        </div>
        <div class="step">
          <span class="num">4</span>
          <h3>@content('home.step4.title')</h3>
          <p>@content('home.step4.desc')</p>
        </div>
        <div class="step">
          <span class="num">5</span>
          <h3>@content('home.step5.title')</h3>
          <p>@content('home.step5.desc')</p>
        </div>
      </div>
    </div>
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
        <div class="card">
          <span class="kicker">@content('home.card1.kicker')</span>
          <h3>@content('home.card1.title')</h3>
          <p>@content('home.card1.desc')</p>
        </div>
        <div class="card">
          <span class="kicker">@content('home.card2.kicker')</span>
          <h3>@content('home.card2.title')</h3>
          <p>@content('home.card2.desc')</p>
        </div>
        <div class="card">
          <span class="kicker">@content('home.card3.kicker')</span>
          <h3>@content('home.card3.title')</h3>
          <p>@content('home.card3.desc')</p>
        </div>
        <div class="card">
          <span class="kicker">@content('home.card4.kicker')</span>
          <h3>@content('home.card4.title')</h3>
          <p>@content('home.card4.desc')</p>
        </div>
        <div class="card">
          <span class="kicker">@content('home.card5.kicker')</span>
          <h3>@content('home.card5.title')</h3>
          <p>@content('home.card5.desc')</p>
        </div>
        <div class="card">
          <span class="kicker">@content('home.card6.kicker')</span>
          <h3>@content('home.card6.title')</h3>
          <p>@content('home.card6.desc')</p>
        </div>
      </div>

      <p class="cards-note">@content('home.cards.note')</p>
      <div class="cards-cta">
        <a href="#">@content('home.cards.cta1')</a>
        <a href="#">@content('home.cards.cta2')</a>
      </div>
    </div>
  </section>

  <!-- POR QUE PELO INSTITUTO -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('home.stats.kicker')</span>
        <h2>@content('home.stats.title')</h2>
      </div>

      <div class="stats-grid">
        <div class="stat">
          <div class="num">@content('home.stat1.num')</div>
          <div class="label">@content('home.stat1.label')</div>
        </div>
        <div class="stat">
          <div class="num">@content('home.stat2.num')</div>
          <div class="label">@content('home.stat2.label')</div>
        </div>
        <div class="stat">
          <div class="num">@content('home.stat3.num')</div>
          <div class="label">@content('home.stat3.label')</div>
        </div>
        <div class="stat">
          <div class="num">@content('home.stat4.num')</div>
          <div class="label">@content('home.stat4.label')</div>
        </div>
      </div>

      <div class="rite-strip">
        <div class="rite-stage"><div class="t">@content('home.rite1.title')</div><div class="s">@content('home.rite1.sub')</div></div>
        <div class="rite-stage"><div class="t">@content('home.rite2.title')</div><div class="s">@content('home.rite2.sub')</div></div>
        <div class="rite-stage"><div class="t">@content('home.rite3.title')</div><div class="s">@content('home.rite3.sub')</div></div>
        <div class="rite-stage"><div class="t">@content('home.rite4.title')</div><div class="s">@content('home.rite4.sub')</div></div>
        <div class="rite-stage"><div class="t">@content('home.rite5.title')</div><div class="s">@content('home.rite5.sub')</div></div>
      </div>

      <div class="stats-copy">
        <p>@content('home.stats.copy1')</p>
        <p>@content('home.stats.copy2')</p>
      </div>

      <div style="margin-top:32px;">
        <a href="{{ route('marco-legal') }}" class="btn btn-outline">@content('home.stats.cta')</a>
      </div>
    </div>
  </section>

  <!-- TRANSPARÊNCIA -->
  <section>
    <div class="wrap transp-grid">
      <div>
        <span class="section-head kicker" style="display:block;">@content('home.transp.kicker')</span>
        <h2 style="margin-bottom:16px;">@content('home.transp.title')</h2>
        <p style="color:var(--ink-soft);font-size:16.5px;">@content('home.transp.text')</p>
        <a href="#" class="btn btn-primary" style="margin-top:26px;">@content('home.transp.cta')</a>
      </div>
      <div class="transp-items">
        <div class="transp-item">
          <h3>@content('home.transp.item1.title')</h3>
          <p>@content('home.transp.item1.desc')</p>
        </div>
        <div class="transp-item">
          <h3>@content('home.transp.item2.title')</h3>
          <p>@content('home.transp.item2.desc')</p>
        </div>
        <div class="transp-item">
          <h3>@content('home.transp.item3.title')</h3>
          <p>@content('home.transp.item3.desc')</p>
        </div>
        <div class="transp-item">
          <h3>@content('home.transp.item4.title')</h3>
          <p>@content('home.transp.item4.desc')</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA FINAL -->
  <section class="final-cta">
    <div class="wrap">
      <div>
        <h2>@content('home.finalcta.title')</h2>
        <p>@content('home.finalcta.text')</p>
      </div>
      <a href="#" class="btn btn-gold">@content('home.finalcta.button')</a>
    </div>
  </section>

@endsection
