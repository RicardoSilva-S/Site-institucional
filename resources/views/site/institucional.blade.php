@extends('layouts.app')

@section('title', 'Institucional | IDTNPR')
@section('description', 'Conheça o IDTNPR: sua natureza jurídica, missão, história, governança e documentos institucionais.')

{{-- Topo com a ficha do Instituto ao lado da imagem da seção
     (partials/section-banner, editável em /adm/banners ou no editor da página),
     atalhos para as seções (os mesmos da Atuação) e seções em duas colunas:
     título de um lado, texto do outro. --}}
@php
  $textos = \App\Support\SiteContent::class;

  // Itens da ficha do topo; um item com o valor excluído no painel some.
  $ficha = collect(['natureza', 'sede', 'fundacao', 'enquadramento'])
      ->map(fn ($item) => [
          'label' => $textos::text("institucional.ficha.{$item}.label"),
          'value' => $textos::text("institucional.ficha.{$item}.value"),
      ])
      ->filter(fn ($item) => trim($item['value']) !== '');

  // "Legalidade · Impessoalidade · ..." vira uma etiqueta por princípio.
  $principios = collect(preg_split('/\s*[·•;]\s*/u', $textos::text('institucional.principios.text')))
      ->map(fn ($principio) => trim($principio))
      ->filter();

  // Passos da linha do tempo; passos excluídos no painel (data e texto vazios) somem.
  $passos = collect(range(1, 5))
      ->map(fn ($i) => [
          'title' => $textos::text("institucional.passo{$i}.title"),
          'text' => $textos::text("institucional.passo{$i}.text"),
      ])
      ->filter(fn ($passo) => trim($passo['title']) !== '' || trim($passo['text']) !== '')
      ->values();

  $diretoria = [
      ['foto' => 'jonny.jpg', 'nome' => 'Jonny de Souza Ribeiro', 'cargo' => 'Presidência', 'classe' => 'team-card--jonny',
       'bio' => 'Economista com pós-graduação em Controladoria e Finanças, com experiência em tecnologia, análise econômica aplicada à gestão pública e projetos de inovação.'],
      ['foto' => 'gilmar.jpg', 'nome' => 'Gilmar Boti Júnior', 'cargo' => 'Diretoria administrativa', 'classe' => '',
       'bio' => 'Graduado em Processos Gerenciais e Gestão Pública, com mais de dez anos de atuação direta no setor público e na administração de contratos.'],
      ['foto' => 'bruno.jpg', 'nome' => 'Bruno Nascimento', 'cargo' => 'Projetos e tecnologia', 'classe' => '',
       'bio' => 'Bacharel em Gestão Pública, consultor e empresário com experiência em processos, modernização administrativa e implantação de sistemas.'],
  ];

  $conselho = [
      ['nome' => 'Vinicius Cancian', 'cargo' => 'Presidente do conselho', 'sigla' => 'VC'],
      ['nome' => 'Anderson de Jesus Ciriaco Lopes', 'cargo' => 'Conselheiro fiscal', 'sigla' => 'AL'],
      ['nome' => 'Walmir Rafael da Silva', 'cargo' => 'Conselheiro consultivo', 'sigla' => 'WS'],
  ];

  // Lista da chamada final: cada item abre a seção correspondente do Portal da Transparência.
  $documentos = collect([
      'doc1' => 'institucional',
      'doc2' => 'governanca',
      'doc3' => 'normativos',
      'doc4' => 'parcerias',
      'doc5' => 'contas',
  ])
      ->map(fn ($secao, $key) => [
          'label' => $textos::text("institucional.cta.{$key}"),
          'url' => route('transparencia').'#'.$secao,
      ])
      ->filter(fn ($doc) => trim($doc['label']) !== '');
@endphp

@section('content')
  <section class="page-hero page-hero--split">
    <div class="wrap">
      <div>
        <span class="eyebrow"><span class="dot"></span> @content('institucional.hero.eyebrow')</span>
        <h1>@content('institucional.hero.title')</h1>
        <p class="lead">@content('institucional.hero.lead')</p>
        @if ($ficha->isNotEmpty())
          <dl class="ficha">
            @foreach ($ficha as $item)
              <div>
                <dt>{{ $item['label'] }}</dt>
                <dd>{{ $item['value'] }}</dd>
              </div>
            @endforeach
          </dl>
        @endif
      </div>
      @include('partials.section-banner', ['slot' => 'hero', 'eager' => true])
    </div>
    @extraTexts('institucional.hero')
  </section>

  <nav class="frentes-nav" aria-label="Seções da página">
    <div class="wrap">
      <ul>
        <li><a href="#quem-somos">@content('institucional.nav.quemsomos')</a></li>
        <li><a href="#linha-do-tempo">@content('institucional.nav.historia')</a></li>
        <li><a href="#governanca">@content('institucional.nav.governanca')</a></li>
        <li><a href="#marco-legal">@content('institucional.nav.marcolegal')</a></li>
        <li><a href="#documentos">@content('institucional.nav.documentos')</a></li>
      </ul>
    </div>
  </nav>

  <section class="inst-section" id="quem-somos">
    <div class="wrap">
      <div class="inst-split">
        <div class="section-head">
          <span class="kicker">@content('institucional.quemsomos.kicker')</span>
          <h2>@content('institucional.quemsomos.title')</h2>
        </div>
        <div class="inst-split__body">
          <p class="inst-lead">@content('institucional.quemsomos.sub')</p>
          <p>@content('institucional.quemsomos.p1')</p>
          <p>@content('institucional.quemsomos.p2')</p>
        </div>
      </div>
      <div class="identidade">
        <div class="identidade__item">
          <h3>@content('institucional.missao.title')</h3>
          <p>@content('institucional.missao.text')</p>
        </div>
        <div class="identidade__item">
          <h3>@content('institucional.visao.title')</h3>
          <p>@content('institucional.visao.text')</p>
        </div>
        <div class="identidade__item">
          <h3>@content('institucional.principios.title')</h3>
          @if ($principios->count() > 1)
            <ul class="principios">
              @foreach ($principios as $principio)
                <li>{{ $principio }}</li>
              @endforeach
            </ul>
          @else
            <p>@content('institucional.principios.text')</p>
          @endif
        </div>
      </div>
    </div>
    @extraTexts('institucional.quemsomos')
    @extraTexts('institucional.identidade')
  </section>

  <section class="alt inst-section" id="linha-do-tempo">
    <div class="wrap">
      <div class="inst-split">
        <div class="section-head">
          <span class="kicker">@content('institucional.historia.kicker')</span>
          <h2>@content('institucional.historia.title')</h2>
          <p class="sub">@content('institucional.historia.sub')</p>
        </div>
        <div class="inst-split__body">
          <p>@content('institucional.historia.p1')</p>
          <p>@content('institucional.historia.p2')</p>
        </div>
      </div>
      @if ($passos->isNotEmpty())
        <ol class="timeline">
          @foreach ($passos as $passo)
            <li @if ($loop->last) class="is-latest" @endif>
              <h3>{{ $passo['title'] }}</h3>
              <p>{{ $passo['text'] }}</p>
            </li>
          @endforeach
        </ol>
      @endif
    </div>
    @extraTexts('institucional.historia')
  </section>

  <section class="inst-section" id="governanca">
    <div class="wrap">
      <div class="inst-split inst-split--end">
        <div class="section-head">
          <span class="kicker">@content('institucional.governanca.kicker')</span>
          <h2>@content('institucional.governanca.title')</h2>
        </div>
        <p class="inst-split__aside">@content('institucional.governanca.sub')</p>
      </div>

      <h3 class="inst-subhead">@content('institucional.governanca.diretoria')</h3>
      <div class="team-grid">
        @foreach ($diretoria as $membro)
          <article class="team-card {{ $membro['classe'] }}">
            <div class="team-card__photo">
              <img src="{{ asset('assets/equipe/'.$membro['foto']) }}" alt="{{ $membro['nome'] }}" loading="lazy">
            </div>
            <div class="team-card__body">
              <span class="inst-label">{{ $membro['cargo'] }}</span>
              <h4>{{ $membro['nome'] }}</h4>
              <p>{{ $membro['bio'] }}</p>
            </div>
          </article>
        @endforeach
      </div>

      <h3 class="inst-subhead">@content('institucional.governanca.conselho')</h3>
      <ul class="conselho">
        @foreach ($conselho as $membro)
          <li>
            <span class="conselho__sigla" aria-hidden="true">{{ $membro['sigla'] }}</span>
            <div>
              <span class="inst-label">{{ $membro['cargo'] }}</span>
              <strong>{{ $membro['nome'] }}</strong>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
    @extraTexts('institucional.governanca')
  </section>

  <section class="alt inst-section" id="marco-legal">
    <div class="wrap">
      <div class="inst-split inst-split--center">
        <div class="section-head">
          <span class="kicker">@content('institucional.marcolegal.kicker')</span>
          <h2>@content('institucional.marcolegal.title')</h2>
          <p class="sub">@content('institucional.marcolegal.sub')</p>
          <a href="{{ route('marco-legal') }}" class="btn btn-outline">@content('institucional.marcolegal.btn')</a>
        </div>
        <div class="link-cards">
          @foreach (['card1', 'card2'] as $card)
            <a class="link-card" href="{{ route('marco-legal') }}">
              <span class="link-card__body">
                <span class="inst-label">@content("institucional.marcolegal.{$card}.kicker")</span>
                <strong>@content("institucional.marcolegal.{$card}.title")</strong>
                <span class="link-card__text">@content("institucional.marcolegal.{$card}.text")</span>
              </span>
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
          @endforeach
        </div>
      </div>
    </div>
    @extraTexts('institucional.marcolegal')
  </section>

  <section class="final-cta final-cta--docs inst-section" id="documentos">
    <div class="wrap">
      <div>
        <h2>@content('institucional.cta.title')</h2>
        <p>@content('institucional.cta.text')</p>
        <a href="{{ route('transparencia') }}" class="btn btn-gold">@content('institucional.cta.btn')</a>
      </div>
      @if ($documentos->isNotEmpty())
        <ul class="doc-links">
          @foreach ($documentos as $doc)
            <li>
              <a href="{{ $doc['url'] }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg>
                <span>{{ $doc['label'] }}</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
    @extraTexts('institucional.cta')
  </section>
@endsection

@push('scripts')
  <script src="{{ asset('js/secoes-nav.js') }}"></script>
@endpush
