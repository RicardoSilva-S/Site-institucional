@extends('layouts.app')

@section('title', 'Editais e Chamamentos Públicos | IDTNPR')
@section('description', 'Acompanhe os editais e chamamentos públicos do IDTNPR: regras claras, critérios objetivos e ampla publicidade na busca por parceiros tecnológicos para prefeituras e câmaras municipais.')

{{-- Página Editais. Os dados dos editais vêm do SiteController@editais
     ($editais e $contagem). Mantém os componentes visuais já existentes no style.css. --}}
@section('content')

  <!-- HERO -->
  <section class="hero">
    <div class="wrap hero-grid">

      <!-- Coluna da esquerda: conteúdo essencial dos editais -->
      <div>
        <span class="eyebrow"><span class="dot"></span> @content('editais.hero.eyebrow')</span>
        <h1>@content('editais.hero.title')</h1>
        <p class="lead">@content('editais.hero.lead')</p>

        <div class="info-grid mt-34">
          <div class="info-box">
            <h3>@content('editais.hero.box1.title')</h3>
            <p>@content('editais.hero.box1.text')</p>
          </div>
          <div class="info-box">
            <h3>@content('editais.hero.box2.title')</h3>
            <p>@content('editais.hero.box2.text')</p>
          </div>
        </div>
      </div>

      <!-- Coluna da direita: ilustração editorial em SVG -->
      <div class="hero-visual" aria-label="Ilustração de um edital público com documento, critérios e transparência digital" role="img">
        <svg viewBox="0 0 520 430" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
          <!-- fundo suave de referência -->
          <circle cx="370" cy="190" r="132" fill="#EDE2C7"/>
          <circle cx="370" cy="190" r="108" fill="#F4EBD7"/>

          <!-- elementos digitais discretos -->
          <path d="M74 345H456" stroke="#0F2A5C" stroke-width="3" stroke-linecap="round"/>
          <path d="M105 326H425" stroke="#0F2A5C" stroke-width="3" stroke-linecap="round"/>
          <path d="M128 326V345M392 326V345" stroke="#0F2A5C" stroke-width="3"/>

          <!-- documento principal -->
          <path d="M157 65H338L386 113V326H157V65Z" fill="#FFFFFF" stroke="#0F2A5C" stroke-width="3" stroke-linejoin="round"/>
          <path d="M338 65V113H386" fill="#F4EBD7" stroke="#0F2A5C" stroke-width="3" stroke-linejoin="round"/>
          <path d="M338 65L386 113" stroke="#0F2A5C" stroke-width="3"/>

          <!-- selo de publicação -->
          <circle cx="220" cy="126" r="31" fill="#F4EBD7" stroke="#B88A2B" stroke-width="3"/>
          <circle cx="220" cy="126" r="20" fill="none" stroke="#0F2A5C" stroke-width="2" stroke-dasharray="3 4"/>
          <path d="M209 126L217 134L233 116" fill="none" stroke="#0F2A5C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>

          <!-- linhas de informação -->
          <path d="M272 113H326M272 129H348M272 145H318" stroke="#0F2A5C" stroke-width="4" stroke-linecap="round" opacity=".9"/>
          <path d="M185 190H348M185 208H348M185 226H315" stroke="#0F2A5C" stroke-width="4" stroke-linecap="round" opacity=".72"/>

          <!-- checklist -->
          <rect x="184" y="256" width="18" height="18" rx="2" fill="#EDE2C7" stroke="#0F2A5C" stroke-width="2.5"/>
          <path d="M189 265L193 269L199 261" fill="none" stroke="#B88A2B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M215 265H348" stroke="#0F2A5C" stroke-width="4" stroke-linecap="round" opacity=".72"/>
          <rect x="184" y="286" width="18" height="18" rx="2" fill="#EDE2C7" stroke="#0F2A5C" stroke-width="2.5"/>
          <path d="M189 295L193 299L199 291" fill="none" stroke="#B88A2B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M215 295H329" stroke="#0F2A5C" stroke-width="4" stroke-linecap="round" opacity=".72"/>

          <!-- sinal de transparência / publicação -->
          <path d="M401 92V238" stroke="#0F2A5C" stroke-width="3" stroke-linecap="round"/>
          <path d="M401 94L448 108L401 122Z" fill="#B88A2B" stroke="#0F2A5C" stroke-width="2" stroke-linejoin="round"/>
          <circle cx="401" cy="250" r="12" fill="#FFFFFF" stroke="#0F2A5C" stroke-width="3"/>
          <path d="M386 275H416M392 286H410" stroke="#0F2A5C" stroke-width="3" stroke-linecap="round"/>
        </svg>
      </div>

    </div>
    @extraTexts('editais.hero')
  </section>

  <!-- COMO FUNCIONA -->
  <section>
    <div class="wrap">
      <div class="split-head">
        <div class="section-head">
          <span class="kicker">@content('editais.etapas.kicker')</span>
          <h2>@content('editais.etapas.title')</h2>
          <p class="sub">@content('editais.etapas.sub')</p>
        </div>
        <div class="split-head__media">
          @include('partials.section-banner', ['slot' => 'etapas'])
        </div>
      </div>

      <div class="steps-carousel">
        <button type="button" class="steps-nav steps-nav--prev" aria-label="Etapa anterior">‹</button>
        <div class="steps-track" tabindex="0" aria-label="Etapas para participar dos editais">
          <div class="step">
            <span class="num">1</span>
            <h3>@content('editais.etapas.etapa1.title')</h3>
            <p>@content('editais.etapas.etapa1.text')</p>
            <span class="free">@content('editais.etapas.etapa1.tag')</span>
          </div>
          <div class="step">
            <span class="num">2</span>
            <h3>@content('editais.etapas.etapa2.title')</h3>
            <p>@content('editais.etapas.etapa2.text')</p>
          </div>
          <div class="step">
            <span class="num">3</span>
            <h3>@content('editais.etapas.etapa3.title')</h3>
            <p>@content('editais.etapas.etapa3.text')</p>
          </div>
          <div class="step">
            <span class="num">4</span>
            <h3>@content('editais.etapas.etapa4.title')</h3>
            <p>@content('editais.etapas.etapa4.text')</p>
          </div>
        </div>
        <button type="button" class="steps-nav steps-nav--next" aria-label="Próxima etapa">›</button>
      </div>
    </div>
    @extraTexts('editais.etapas')
  </section>

  <!-- INFORMAÇÕES INSTITUCIONAIS: conteúdo antes exibido no cartão azul do Hero -->
  <section class="alt">
    <div class="wrap">
      <div class="split-head">
        <div class="section-head">
          <span class="kicker">@content('editais.parceria.kicker')</span>
          <h2>@content('editais.parceria.title')</h2>
          <p class="sub">@content('editais.parceria.sub')</p>
        </div>
        <div class="split-head__media">
          @include('partials.section-banner', ['slot' => 'parceria'])
        </div>
      </div>

      <div class="info-grid">
        <div class="info-box">
          <h3>@content('editais.parceria.box1.title')</h3>
          <p>@content('editais.parceria.box1.text')</p>
        </div>
        <div class="info-box">
          <h3>@content('editais.parceria.box2.title')</h3>
          <p>@content('editais.parceria.box2.text')</p>
        </div>
        <div class="info-box">
          <h3>@content('editais.parceria.box3.title')</h3>
          <p>@content('editais.parceria.box3.text')</p>
          <div class="cards-cta">
            <a href="{{ route('contato') }}">@content('editais.parceria.box3.link')</a>
          </div>
        </div>
      </div>
    </div>
    @extraTexts('editais.parceria')
  </section>

  <!-- QUADRO DE AVISOS -->
  <section>
    <div class="wrap">
      <div class="split-head">
        <div class="section-head">
          <span class="kicker">@content('editais.avisos.kicker')</span>
          <h2>@content('editais.avisos.title')</h2>
          <p class="sub">@content('editais.avisos.sub')</p>
        </div>
        <div class="split-head__media">
          @include('partials.section-banner', ['slot' => 'avisos'])
        </div>
      </div>

      <div class="stats-grid">
        <div class="stat">
          <div class="num">{{ $contagem->get('aberto', 0) }}</div>
          <div class="label">@content('editais.avisos.stat1')</div>
        </div>
        <div class="stat">
          <div class="num">{{ $contagem->get('analise', 0) }}</div>
          <div class="label">@content('editais.avisos.stat2')</div>
        </div>
        <div class="stat">
          <div class="num">{{ $contagem->get('encerrado', 0) }}</div>
          <div class="label">@content('editais.avisos.stat3')</div>
        </div>
        <div class="stat">
          <div class="num">{{ $editais->count() }}</div>
          <div class="label">@content('editais.avisos.stat4') {{ now()->year }}</div>
        </div>
      </div>

      <div class="legal-note">
        <h3>@content('editais.avisos.nota.title')</h3>
        <p>@content('editais.avisos.nota.text')</p>
      </div>
    </div>
    @extraTexts('editais.avisos')
  </section>

  <!-- LISTA DE EDITAIS -->
  <section id="lista-editais">
    <div class="wrap">
      <div class="split-head">
        <div class="section-head">
          <span class="kicker">@content('editais.lista.kicker')</span>
          <h2>@content('editais.lista.title') {{ now()->year }}</h2>
          <p class="sub">@content('editais.lista.sub')</p>
        </div>
        <div class="split-head__media">
          @include('partials.section-banner', ['slot' => 'lista'])
        </div>
      </div>

      <div class="doc-filters" role="group" aria-label="Filtrar editais por situação">
        <button type="button" class="chip is-active" data-filter="todos" aria-pressed="true">Todos</button>
        <button type="button" class="chip" data-filter="aberto" aria-pressed="false">Abertos</button>
        <button type="button" class="chip" data-filter="analise" aria-pressed="false">Em análise</button>
        <button type="button" class="chip" data-filter="encerrado" aria-pressed="false">Encerrados</button>
      </div>

      <div class="norma-grid">
        {{-- Editais cadastrados no painel (/adm/editais). O botão só aparece
             quando o edital tem PDF enviado. --}}
        @foreach ($editais as $edital)
          <article class="card" data-edital-status="{{ $edital->status }}">
            <span class="kicker"><span class="status {{ $edital->classe() }}">{{ $edital->rotulo() }}</span></span>
            <h3>{{ $edital->titulo }}</h3>
            @if ($edital->resumo)<p>{{ $edital->resumo }}</p>@endif

            <dl class="ficha">
              @if ($edital->abertura)
                <div>
                  <dt>Abertura</dt>
                  <dd>{{ $edital->abertura->format('d/m/Y') }}</dd>
                </div>
              @endif
              @if ($edital->encerramento)
                <div>
                  <dt>Encerramento</dt>
                  <dd>{{ $edital->encerramento->format('d/m/Y') }}</dd>
                </div>
              @endif
            </dl>

            @if ($edital->temArquivo())
              <div class="proc-cta-row">
                <a href="{{ route('editais.pdf', $edital) }}" target="_blank" rel="noopener" class="btn {{ $edital->status === 'aberto' ? 'btn-primary' : 'btn-outline' }}">{{ $edital->acao() }}</a>
              </div>
            @endif
          </article>
        @endforeach
      </div>

      <div class="doc-empty" role="status">@content('editais.lista.vazio')</div>
    </div>
    @extraTexts('editais.lista')
  </section>

  <!-- CTA FINAL -->
  <section class="final-cta">
    <div class="wrap">
      <div>
        <h2>@content('editais.cta.title')</h2>
        <p>@content('editais.cta.text')</p>
      </div>
      <a href="{{ route('contato') }}" class="btn btn-gold">@content('editais.cta.btn')</a>
    </div>
    @extraTexts('editais.cta')
  </section>

@endsection

@push('scripts')
  <script>
    (function () {
      var chips = document.querySelectorAll('.doc-filters .chip');
      var cards = document.querySelectorAll('[data-edital-status]');
      var empty = document.querySelector('.doc-empty');
      chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
          var filtro = chip.getAttribute('data-filter');
          var visiveis = 0;
          chips.forEach(function (c) {
            c.classList.toggle('is-active', c === chip);
            c.setAttribute('aria-pressed', c === chip ? 'true' : 'false');
          });
          cards.forEach(function (card) {
            var ok = filtro === 'todos' || card.getAttribute('data-edital-status') === filtro;
            card.hidden = !ok;
            if (ok) { visiveis++; }
          });
          empty.classList.toggle('is-visible', visiveis === 0);
        });
      });
    })();
  </script>
@endpush
