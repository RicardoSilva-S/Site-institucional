@extends('layouts.app')

@section('title', 'Marco Legal | IDTNPR')
@section('description', 'A base legal da atuação do IDTNPR: as normas nacionais e estaduais que sustentam a cooperação, o enquadramento como ICT e os seis instrumentos jurídicos de contratação, cada um com sua fundamentação.')

@section('content')

  <!-- HERO -->
  <section class="page-hero">
    <div class="wrap">
      <h1>@content('marcolegal.hero.title')</h1>
      <p class="lead">@content('marcolegal.hero.lead')</p>
    </div>
    @extraTexts('marcolegal.hero')
  </section>

  <!-- AS NORMAS -->
  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('marcolegal.normas.kicker')</span>
        <h2>@content('marcolegal.normas.title')</h2>
      </div>

      <div class="norma-grid">
        <div class="norma-card">
          <span class="ref">@content('marcolegal.norma1.ref')</span>
          <p class="desc">@content('marcolegal.norma1.desc')</p>
        </div>
        <div class="norma-card">
          <span class="ref">@content('marcolegal.norma2.ref')</span>
          <p class="desc">@content('marcolegal.norma2.desc')</p>
        </div>
        <div class="norma-card">
          <span class="ref">@content('marcolegal.norma3.ref')</span>
          <p class="desc">@content('marcolegal.norma3.desc')</p>
        </div>
        <div class="norma-card">
          <span class="ref">@content('marcolegal.norma4.ref')</span>
          <p class="desc">@content('marcolegal.norma4.desc')</p>
        </div>
        <div class="norma-card">
          <span class="ref">@content('marcolegal.norma5.ref')</span>
          <p class="desc">@content('marcolegal.norma5.desc')</p>
        </div>
        <div class="norma-card">
          <span class="ref">@content('marcolegal.norma6.ref')</span>
          <p class="desc">@content('marcolegal.norma6.desc')</p>
        </div>
        <div class="norma-card">
          <span class="ref">@content('marcolegal.norma7.ref')</span>
          <p class="desc">@content('marcolegal.norma7.desc')</p>
        </div>
        <div class="norma-card">
          <span class="ref">@content('marcolegal.norma8.ref')</span>
          <p class="desc">@content('marcolegal.norma8.desc')</p>
        </div>
      </div>
    </div>
    @extraTexts('marcolegal.normas')
  </section>

  <!-- ICT -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('marcolegal.ict.kicker')</span>
      </div>

      <div class="qa-block">
        <p class="question">@content('marcolegal.ict.question')</p>
        <p class="answer">@content('marcolegal.ict.answer')</p>
      </div>

      <div class="info-grid">
        <div class="info-box">
          <h3>@content('marcolegal.ict.def.title')</h3>
          <p>@content('marcolegal.ict.def.text')</p>
        </div>
        <div class="info-box">
          <h3>@content('marcolegal.ict.req.title')</h3>
          <ul class="req-list">
            <li>@content('marcolegal.ict.req1')</li>
            <li>@content('marcolegal.ict.req2')</li>
            <li>@content('marcolegal.ict.req3')</li>
            <li>@content('marcolegal.ict.req4')</li>
          </ul>
        </div>
      </div>

      <div class="info-box" style="margin-top:18px;">
        <h3>@content('marcolegal.ict.verif.title')</h3>
        <p>@content('marcolegal.ict.verif.text')</p>
      </div>
    </div>
    @extraTexts('marcolegal.ict')
  </section>

  <!-- O MAPA -->
  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('marcolegal.mapa.kicker')</span>
        <h2>@content('marcolegal.mapa.title')</h2>
        <p class="sub">@content('marcolegal.mapa.intro')</p>
      </div>

      <div class="legal-table">
        <table>
          <thead>
            <tr>
              <th>@content('marcolegal.mapa.col1')</th>
              <th>@content('marcolegal.mapa.col2')</th>
              <th>@content('marcolegal.mapa.col3')</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="situacao">@content('marcolegal.mapa.row1.situacao')</td>
              <td class="instrumento">@content('marcolegal.mapa.row1.instrumento')</td>
              <td class="fundamento">@content('marcolegal.mapa.row1.fundamento')</td>
            </tr>
            <tr>
              <td class="situacao">@content('marcolegal.mapa.row2.situacao')</td>
              <td class="instrumento">@content('marcolegal.mapa.row2.instrumento')</td>
              <td class="fundamento">@content('marcolegal.mapa.row2.fundamento')</td>
            </tr>
            <tr>
              <td class="situacao">@content('marcolegal.mapa.row3.situacao')</td>
              <td class="instrumento">@content('marcolegal.mapa.row3.instrumento')</td>
              <td class="fundamento">@content('marcolegal.mapa.row3.fundamento')</td>
            </tr>
            <tr>
              <td class="situacao">@content('marcolegal.mapa.row4.situacao')</td>
              <td class="instrumento">@content('marcolegal.mapa.row4.instrumento')</td>
              <td class="fundamento">@content('marcolegal.mapa.row4.fundamento')</td>
            </tr>
            <tr>
              <td class="situacao">@content('marcolegal.mapa.row5.situacao')</td>
              <td class="instrumento">@content('marcolegal.mapa.row5.instrumento')</td>
              <td class="fundamento">@content('marcolegal.mapa.row5.fundamento')</td>
            </tr>
            <tr>
              <td class="situacao">@content('marcolegal.mapa.row6.situacao')</td>
              <td class="instrumento">@content('marcolegal.mapa.row6.instrumento')</td>
              <td class="fundamento">@content('marcolegal.mapa.row6.fundamento')</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="legal-note">
        <h3>@content('marcolegal.mapa.none.title')</h3>
        <p>@content('marcolegal.mapa.none.text')</p>
      </div>
    </div>
    @extraTexts('marcolegal.mapa')
  </section>

  <!-- PROCURADORIAS -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('marcolegal.proc.kicker')</span>
        <h2>@content('marcolegal.proc.title')</h2>
      </div>

      <div class="proc-card">
        <p>@content('marcolegal.proc.text1')</p>
        <p>@content('marcolegal.proc.text2')</p>

        <div class="proc-cta-row">
          <a href="https://wa.me/5544998083001" class="btn btn-primary" target="_blank" rel="noopener">@content('marcolegal.proc.cta1')</a>
          <a href="mailto:faleconosco@idtnpr.org.br" class="btn btn-outline">@content('marcolegal.proc.cta2')</a>
        </div>

        <p class="proc-disclaimer">@content('marcolegal.proc.disclaimer')</p>
      </div>
    </div>
    @extraTexts('marcolegal.procuradorias')
  </section>

@endsection
