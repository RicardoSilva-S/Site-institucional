@extends('layouts.app')

@section('title', 'Institucional | IDTNPR')
@section('description', 'Conheça o IDTNPR: sua natureza jurídica, missão, história, governança e documentos institucionais.')

@push('styles')
<style>
  .team-card {
    overflow: hidden;
    padding: 0;
  }

  .team-card img {
    aspect-ratio: 1;
    display: block;
    object-fit: cover;
    width: 100%;
  }

  .team-card__photo {
    overflow: hidden;
  }

  .team-card--jonny .team-card__photo img {
    transform: scale(1.18);
    transform-origin: center 18%;
  }

  .team-card__body {
    padding: 28px;
  }
</style>
@endpush

@section('content')
  <section class="page-hero">
    <div class="wrap">
      <span class="eyebrow"><span class="dot"></span> @content('institucional.hero.eyebrow')</span>
      <h1>@content('institucional.hero.title')</h1>
      <p class="lead">@content('institucional.hero.lead')</p>
    </div>
    @extraTexts('institucional.hero')
  </section>

  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('institucional.quemsomos.kicker')</span>
        <h2>@content('institucional.quemsomos.title')</h2>
        <p class="sub">@content('institucional.quemsomos.sub')</p>
      </div>
      <div class="info-box">
        <p>@content('institucional.quemsomos.p1')</p>
        <p style="margin-top:14px;">@content('institucional.quemsomos.p2')</p>
      </div>
      <div class="qa-block" style="margin-top:24px;">
        <p class="question">@content('institucional.missao.title')</p>
        <p class="answer">@content('institucional.missao.text')</p>
        <p class="question" style="margin-top:24px;">@content('institucional.visao.title')</p>
        <p class="answer">@content('institucional.visao.text')</p>
        <p class="question" style="margin-top:24px;">@content('institucional.principios.title')</p>
        <p class="answer">@content('institucional.principios.text')</p>
      </div>
    </div>
    @extraTexts('institucional.quemsomos')
    @extraTexts('institucional.identidade')
  </section>

  <section class="alt" id="linha-do-tempo">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('institucional.historia.kicker')</span>
        <h2>@content('institucional.historia.title')</h2>
        <p class="sub">@content('institucional.historia.sub')</p>
      </div>
      <div class="stats-copy" style="margin-top:0;">
        <p>@content('institucional.historia.p1')</p>
        <p>@content('institucional.historia.p2')</p>
      </div>
      <div class="steps-track" style="margin-top:36px;">
        <article class="step"><span class="num">1</span><h3>@content('institucional.passo1.title')</h3><p>@content('institucional.passo1.text')</p></article>
        <article class="step"><span class="num">2</span><h3>@content('institucional.passo2.title')</h3><p>@content('institucional.passo2.text')</p></article>
        <article class="step"><span class="num">3</span><h3>@content('institucional.passo3.title')</h3><p>@content('institucional.passo3.text')</p></article>
        <article class="step"><span class="num">4</span><h3>@content('institucional.passo4.title')</h3><p>@content('institucional.passo4.text')</p></article>
        <article class="step"><span class="num">5</span><h3>@content('institucional.passo5.title')</h3><p>@content('institucional.passo5.text')</p></article>
      </div>
    </div>
    @extraTexts('institucional.historia')
  </section>

  <section id="governanca">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('institucional.governanca.kicker')</span>
        <h2>@content('institucional.governanca.title')</h2>
        <p class="sub">@content('institucional.governanca.sub')</p>
      </div>
      <h3 style="margin-bottom:18px;">@content('institucional.governanca.diretoria')</h3>
      <div class="cards-grid">
        <article class="card team-card team-card--jonny">
          <div class="team-card__photo">
            <img src="{{ asset('assets/equipe/jonny.jpg') }}" alt="Jonny de Souza Ribeiro" loading="lazy">
          </div>
          <div class="team-card__body">
            <span class="kicker">Presidência</span>
            <h3>Jonny de Souza Ribeiro</h3>
            <p>Economista com pós-graduação em Controladoria e Finanças, com experiência em tecnologia, análise econômica aplicada à gestão pública e projetos de inovação.</p>
          </div>
        </article>
        <article class="card team-card">
          <img src="{{ asset('assets/equipe/gilmar.jpg') }}" alt="Gilmar Boti Júnior" loading="lazy">
          <div class="team-card__body">
            <span class="kicker">Diretoria administrativa</span>
            <h3>Gilmar Boti Júnior</h3>
            <p>Graduado em Processos Gerenciais e Gestão Pública, com mais de dez anos de atuação direta no setor público e na administração de contratos.</p>
          </div>
        </article>
        <article class="card team-card">
          <img src="{{ asset('assets/equipe/bruno.jpg') }}" alt="Bruno Nascimento" loading="lazy">
          <div class="team-card__body">
            <span class="kicker">Projetos e tecnologia</span>
            <h3>Bruno Nascimento</h3>
            <p>Bacharel em Gestão Pública, consultor e empresário com experiência em processos, modernização administrativa e implantação de sistemas.</p>
          </div>
        </article>
      </div>
      <h3 style="margin:42px 0 18px;">@content('institucional.governanca.conselho')</h3>
      <div class="cards-grid">
        <article class="card"><span class="kicker">Presidente do conselho</span><h3>Vinicius Cancian</h3></article>
        <article class="card"><span class="kicker">Conselheiro fiscal</span><h3>Anderson de Jesus Ciriaco Lopes</h3></article>
        <article class="card"><span class="kicker">Conselheiro consultivo</span><h3>Walmir Rafael da Silva</h3></article>
      </div>
    </div>
    @extraTexts('institucional.governanca')
  </section>

  <section class="alt">
    <div class="wrap">
      <div class="problem-grid">
        <div class="section-head" style="margin-bottom:0;">
          <span class="kicker">@content('institucional.marcolegal.kicker')</span>
          <h2>@content('institucional.marcolegal.title')</h2>
          <p class="sub">@content('institucional.marcolegal.sub')</p>
          <a href="{{ route('marco-legal') }}" class="btn btn-outline" style="margin-top:26px;">@content('institucional.marcolegal.btn')</a>
        </div>
        <div class="cards-grid" style="grid-template-columns:1fr 1fr;">
          <article class="card"><span class="kicker">@content('institucional.marcolegal.card1.kicker')</span><h3>@content('institucional.marcolegal.card1.title')</h3><p>@content('institucional.marcolegal.card1.text')</p></article>
          <article class="card"><span class="kicker">@content('institucional.marcolegal.card2.kicker')</span><h3>@content('institucional.marcolegal.card2.title')</h3><p>@content('institucional.marcolegal.card2.text')</p></article>
        </div>
      </div>
    </div>
    @extraTexts('institucional.marcolegal')
  </section>

  <section class="final-cta">
    <div class="wrap">
      <div>
        <h2>@content('institucional.cta.title')</h2>
        <p>@content('institucional.cta.text')</p>
      </div>
      <a href="{{ route('transparencia') }}" class="btn btn-gold">@content('institucional.cta.btn')</a>
    </div>
    @extraTexts('institucional.cta')
  </section>
@endsection
