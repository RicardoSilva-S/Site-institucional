@extends('layouts.app')

@section('title', 'Política de Privacidade | IDTNPR')
@section('description', 'Como o IDTNPR coleta, usa e protege os dados pessoais de quem utiliza este site, conforme a LGPD (Lei nº 13.709/2018).')

@push('styles')
<style>
  .policy-list { margin: 12px 0 0 20px; }
  .policy-list li { margin-bottom: 8px; color: var(--ink-soft); }
  .policy-updated { margin-top: 14px; font-size: 14px; opacity: .8; }

  .policy-feature { display: flex; gap: 16px; align-items: flex-start; }
  .policy-feature + .policy-feature { margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--line); }
  .policy-icon {
    flex-shrink: 0; width: 52px; height: 52px; border-radius: 50%;
    background: var(--gold-soft); color: var(--navy);
    display: flex; align-items: center; justify-content: center;
  }
  .policy-icon svg { width: 26px; height: 26px; }
  .policy-feature h3 { font-size: 19.5px; line-height: 1.3; margin-bottom: 6px; color: var(--ink); }
  .section-head .kicker { font-size:19px; letter-spacing: .04em; }
  .policy-hero { display: flex; align-items: center; gap: 44px; }
  .policy-hero-icon { margin-left: -218px; }
  .policy-hero-icon { flex-shrink: 0; width: 190px; height: 190px; border-radius: 22px; }
  .policy-hero-icon svg { display: block; width: 100%; height: auto; }
  @media (max-width: 760px) {
  .policy-hero { flex-direction: column; align-items: flex-start; gap: 20px; }
  .policy-hero-icon { width: 110px; }
  }
</style>
@endpush

@section('content')

  <!-- TOPO -->
   <section class="page-hero">
    <div class="wrap policy-hero">
      <div class="policy-hero-icon" aria-hidden="true">
        <svg viewBox="0 0 200 228" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="100" cy="218" rx="52" ry="6" fill="#0F2A5C" opacity=".12"/>
          <path d="M100 8 L182 37 V100 C182 152 147 190 100 210 C53 190 18 152 18 100 V37 Z" fill="#F2E6CE"/>
          <path d="M100 23 L169 47 V100 C169 143 140 176 100 194 C60 176 31 143 31 100 V47 Z" fill="#1F4C91"/>
          <path d="M100 23 L169 47 V100 C169 143 140 176 100 194 Z" fill="#0F2A5C"/>
          <path d="M80 100 V82 a20 20 0 0 1 40 0 V100" fill="none" stroke="#fff" stroke-width="11" stroke-linecap="round"/>
          <rect x="66" y="96" width="68" height="54" rx="9" fill="#fff"/>
          <circle cx="100" cy="117" r="8" fill="#0F2A5C"/>
          <rect x="96" y="119" width="8" height="17" rx="3" fill="#0F2A5C"/>
        </svg>
      </div>
      <div>
        <span class="eyebrow"><span class="dot"></span> @content('privacidade.hero.eyebrow')</span>
        <h1>@content('privacidade.hero.title')</h1>
        <p class="lead">@content('privacidade.hero.lead')</p>
        <p class="policy-updated">@content('privacidade.hero.atualizacao')</p>
      </div>
    </div>
    @extraTexts('privacidade.hero')
  </section>

  <!-- CONTROLADOR E DADOS -->
  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('privacidade.controlador.kicker')</span>
        <h2>@content('privacidade.controlador.title')</h2>
      </div>
      <div class="info-box">
        <p>@content('privacidade.controlador.text')</p>
      </div>

      <div class="section-head" style="margin-top:48px;">
        <span class="kicker">@content('privacidade.coleta.kicker')</span>
        <h2>@content('privacidade.coleta.title')</h2>
      </div>
      <div class="info-box">
        <p>@content('privacidade.coleta.text')</p>
        <ul class="policy-list">
          <li>@content('privacidade.coleta.item1')</li>
          <li>@content('privacidade.coleta.item2')</li>
          <li>@content('privacidade.coleta.item3')</li>
          <li>@content('privacidade.coleta.item4')</li>
        </ul>
      </div>
    </div>
    @extraTexts('privacidade.dados')
  </section>

  <!-- FINALIDADE E COOKIES -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('privacidade.uso.kicker')</span>
        <h2>@content('privacidade.uso.title')</h2>
      </div>
      <div class="info-box">
        <p>@content('privacidade.uso.text')</p>
      </div>

      <div class="section-head" style="margin-top:48px;">
        <span class="kicker">@content('privacidade.cookies.kicker')</span>
        <h2>@content('privacidade.cookies.title')</h2>
      </div>
      <div class="info-box">
        <p>@content('privacidade.cookies.text')</p>
      </div>
    </div>
    @extraTexts('privacidade.uso')
  </section>

  <!-- ARMAZENAMENTO E DIREITOS -->
  <section>
    <div class="wrap">
            <div class="section-head">
        <span class="kicker">@content('privacidade.armazenamento.kicker')</span>
        <h2>@content('privacidade.armazenamento.title')</h2>
      </div>
      <div class="info-box">
        <p>@content('privacidade.armazenamento.p1')</p>
        <p style="margin-top:14px;">@content('privacidade.armazenamento.p2')</p>
      </div>

      <div class="section-head" style="margin-top:48px;">
        <span class="kicker">@content('privacidade.direitos.kicker')</span>
        <h2>@content('privacidade.direitos.title')</h2>
      </div>
      <div class="info-box">
        <p>@content('privacidade.direitos.text')</p>
        <ul class="policy-list">
          <li>@content('privacidade.direitos.item1')</li>
          <li>@content('privacidade.direitos.item2')</li>
          <li>@content('privacidade.direitos.item3')</li>
          <li>@content('privacidade.direitos.item4')</li>
          <li>@content('privacidade.direitos.item5')</li>
        </ul>
      </div>
    </div>
    @extraTexts('privacidade.direitos')
  </section>

  <!-- CONTATO -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">@content('privacidade.contato.kicker')</span>
        <h2>@content('privacidade.contato.title')</h2>
        <p class="sub">@content('privacidade.contato.sub')</p>
      </div>
      <div class="info-box">
        <div class="policy-feature">
          <span class="policy-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="5" width="18" height="14" rx="2"/>
              <path d="M3 7l9 6 9-6"/>
            </svg>
          </span>
          <div>
            <h3>@content('privacidade.contato.email')</h3>
            <p><a href="mailto:faleconosco@idtnpr.org.br">faleconosco@idtnpr.org.br</a></p>
          </div>
        </div>

        <div class="policy-feature">
          <span class="policy-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12a9 9 0 0 1-13.5 7.8L3 21l1.2-4.5A9 9 0 1 1 21 12z"/>
            </svg>
          </span>
          <div>
            <h3>@content('privacidade.contato.whatsapp')</h3>
            <p><a href="https://wa.me/5544998083001" target="_blank" rel="noopener">(44) 99808-3001</a></p>
          </div>
        </div>
      </div>

      <p style="margin-top:24px;">
        <a href="{{ url('/contato') }}" class="btn btn-primary">@content('privacidade.contato.btn')</a>
      </p>
    </div>
    @extraTexts('privacidade.contato')
  </section>
@endsection 