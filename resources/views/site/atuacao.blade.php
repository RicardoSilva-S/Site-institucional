@extends('layouts.app')

@section('title', 'Atuação | IDTNPR')
@section('description', 'Conheça as frentes de atuação do IDTNPR para modernizar a gestão pública, estruturar políticas de inovação e apoiar municípios com soluções tecnológicas.')

@section('content')
  <section class="page-hero">
    <div class="wrap">
      <span class="eyebrow"><span class="dot"></span> @content('atuacao.hero.eyebrow')</span>
      <h1>@content('atuacao.hero.title')</h1>
      <p class="lead">@content('atuacao.hero.lead')</p>
    </div>
    @extraTexts('atuacao.hero')
  </section>

  <section id="governanca-publica">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('atuacao.governanca.kicker')</span>
        <h2>@content('atuacao.governanca.title')</h2>
        <p class="sub">@content('atuacao.governanca.sub')</p>
      </div>
      <div class="info-box">
        <p>@content('atuacao.governanca.text')</p>
        <ul class="req-list">
          <li><strong>@content('atuacao.governanca.item1.title')</strong> @content('atuacao.governanca.item1.text')</li>
          <li><strong>@content('atuacao.governanca.item2.title')</strong> @content('atuacao.governanca.item2.text')</li>
          <li><strong>@content('atuacao.governanca.item3.title')</strong> @content('atuacao.governanca.item3.text')</li>
          <li><strong>@content('atuacao.governanca.item4.title')</strong>@content('atuacao.governanca.item4.text')</li>
        </ul>
      </div>
    </div>
    @extraTexts('atuacao.governanca')
  </section>

  <section class="alt" id="observatorio">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('atuacao.observatorio.kicker')</span>
        <h2>@content('atuacao.observatorio.title')</h2>
        <p class="sub">@content('atuacao.observatorio.sub')</p>
      </div>
      <div class="info-box">
        <p>@content('atuacao.observatorio.text')</p>
        <ul class="req-list">
          <li><strong>@content('atuacao.observatorio.item1.title')</strong> @content('atuacao.observatorio.item1.text')</li>
          <li><strong>@content('atuacao.observatorio.item2.title')</strong> @content('atuacao.observatorio.item2.text')</li>
          <li><strong>@content('atuacao.observatorio.item3.title')</strong> @content('atuacao.observatorio.item3.text')</li>
          <li><strong>@content('atuacao.observatorio.item4.title')</strong> @content('atuacao.observatorio.item4.text')</li>
        </ul>
      </div>
    </div>
    @extraTexts('atuacao.observatorio')
  </section>

  <section id="pmo">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('atuacao.pmo.kicker')</span>
        <h2>@content('atuacao.pmo.title')</h2>
        <p class="sub">@content('atuacao.pmo.sub')</p>
      </div>
      <div class="qa-block">
        <p class="question">@content('atuacao.pmo.question')</p>
        <p class="answer">@content('atuacao.pmo.answer') <em>@content('atuacao.pmo.answer.highlight')</em>@content('atuacao.pmo.answer.end')</p>
      </div>
      <div class="legal-note">
        <h3>@content('atuacao.pmo.note.title')</h3>
        <p>@content('atuacao.pmo.note.text')</p>
      </div>
    </div>
    @extraTexts('atuacao.pmo')
  </section>

  <section class="alt" id="marco-legal-inovacao">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('atuacao.marcolegal.kicker')</span>
        <h2>@content('atuacao.marcolegal.title')</h2>
        <p class="sub">@content('atuacao.marcolegal.sub')</p>
      </div>
      <div class="info-box">
        <p>@content('atuacao.marcolegal.text')</p>
        <ul class="req-list">
          <li><strong>@content('atuacao.marcolegal.item1.title')</strong> @content('atuacao.marcolegal.item1.text')</li>
          <li><strong>@content('atuacao.marcolegal.item2.title')</strong> @content('atuacao.marcolegal.item2.text')</li>
          <li><strong>@content('atuacao.marcolegal.item3.title')</strong>@content('atuacao.marcolegal.item3.text')</li>
          <li><strong>@content('atuacao.marcolegal.item4.title')</strong>@content('atuacao.marcolegal.item4.text')</li>
        </ul>
      </div>
      <p class="cards-note">@content('atuacao.marcolegal.note.start') <strong>@content('atuacao.marcolegal.note.highlight')</strong>@content('atuacao.marcolegal.note.end')</p>
    </div>
    @extraTexts('atuacao.marcolegal')
  </section>

  <section id="capacitacao">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('atuacao.capacitacao.kicker')</span>
        <h2>@content('atuacao.capacitacao.title')</h2>
        <p class="sub">@content('atuacao.capacitacao.sub')</p>
      </div>
      <div class="cards-grid">
        <article class="card"><h3>@content('atuacao.capacitacao.card1.title')</h3><p>@content('atuacao.capacitacao.card1.text')</p></article>
        <article class="card"><h3>@content('atuacao.capacitacao.card2.title')</h3><p>@content('atuacao.capacitacao.card2.text')</p></article>
        <article class="card"><h3>@content('atuacao.capacitacao.card3.title')</h3><p>@content('atuacao.capacitacao.card3.text')</p></article>
        <article class="card"><h3>@content('atuacao.capacitacao.card4.title')</h3><p>@content('atuacao.capacitacao.card4.text')</p></article>
        <article class="card"><h3>@content('atuacao.capacitacao.card5.title')</h3><p>@content('atuacao.capacitacao.card5.text')</p></article>
        <article class="card"><h3>@content('atuacao.capacitacao.card6.title')</h3><p>@content('atuacao.capacitacao.card6.text')</p></article>
      </div>
    </div>
    @extraTexts('atuacao.capacitacao')
  </section>

  <section class="alt" id="piloto">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('atuacao.piloto.kicker')</span>
        <h2>@content('atuacao.piloto.title')</h2>
        <p class="sub">@content('atuacao.piloto.sub')</p>
      </div>
      <div class="info-box">
        <p>@content('atuacao.piloto.text')</p>
      </div>
      <div class="legal-note" style="margin-top:18px;">
        <h3>@content('atuacao.piloto.note.title')</h3>
        <p><strong>@content('atuacao.piloto.note.highlight')</strong> @content('atuacao.piloto.note.text')</p>
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
