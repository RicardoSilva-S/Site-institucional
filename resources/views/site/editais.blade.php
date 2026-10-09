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
        <span class="eyebrow"><span class="dot"></span> Transparência e inovação aberta</span>
        <h1>Editais e Chamamentos Públicos</h1>
        <p class="lead">O IDTNPR conduz seus chamamentos com regras claras, critérios objetivos e ampla publicidade. A cada edital, abrimos o Instituto à inovação aberta e buscamos parceiros tecnológicos capazes de entregar soluções seguras e comprovadas para prefeituras e câmaras municipais.</p>

        <div class="info-grid" style="margin-top:34px;">
          <div class="info-box">
            <h3>Quem pode participar</h3>
            <p>Empresas, startups e ICTs de tecnologia</p>
          </div>
          <div class="info-box">
            <h3>Onde são publicados</h3>
            <p>Esta página e Portal da Transparência</p>
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
  </section>

  <!-- COMO FUNCIONA -->
  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Como participar</span>
        <h2>Da qualificação à homologação, em quatro etapas</h2>
        <p class="sub">O mesmo caminho vale para todos os chamamentos. Cada etapa é documentada, os critérios são públicos e o resultado é divulgado para qualquer cidadão consultar.</p>
      </div>

      <div class="steps-carousel">
        <button type="button" class="steps-nav steps-nav--prev" aria-label="Etapa anterior">‹</button>
        <div class="steps-track" tabindex="0" aria-label="Etapas para participar dos editais">
          <div class="step">
            <span class="num">1</span>
            <h3>Qualificação</h3>
            <p>A empresa reúne e envia a documentação de habilitação jurídica, fiscal, trabalhista e técnica, comprovando regularidade e experiência na solução que pretende ofertar.</p>
            <span class="free">Etapa documental</span>
          </div>
          <div class="step">
            <span class="num">2</span>
            <h3>Submissão da Proposta</h3>
            <p>Dentro do prazo do edital, a empresa protocola a proposta com a descrição técnica da solução, o modelo de implantação, o cronograma e a forma de contratação prevista.</p>
          </div>
          <div class="step">
            <span class="num">3</span>
            <h3>Avaliação Técnica</h3>
            <p>Uma comissão analisa as propostas com critérios objetivos divulgados no edital, como aderência ao objeto, segurança da informação, adequação à LGPD e interoperabilidade. Pode haver demonstração prática da solução.</p>
          </div>
          <div class="step">
            <span class="num">4</span>
            <h3>Homologação</h3>
            <p>O resultado é publicado, abre-se prazo para recurso e, encerrada essa fase, o Instituto homologa o chamamento. As soluções aprovadas passam a integrar o catálogo disponível para contratação pelos entes públicos.</p>
          </div>
        </div>
        <button type="button" class="steps-nav steps-nav--next" aria-label="Próxima etapa">›</button>
      </div>
    </div>
  </section>

  <!-- INFORMAÇÕES INSTITUCIONAIS: conteúdo antes exibido no cartão azul do Hero -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Parceria tecnológica</span>
        <h2>Inovação aberta para necessidades reais do município.</h2>
        <p class="sub">O Instituto conecta o ecossistema de inovação às demandas concretas da administração pública municipal, mantendo o processo acessível e orientado por critérios públicos.</p>
      </div>

      <div class="info-grid">
        <div class="info-box">
          <h3>Portal oficial</h3>
          <p>Todos os documentos, avisos, retificações e resultados são divulgados nesta página e no Portal da Transparência.</p>
        </div>
        <div class="info-box">
          <h3>Critérios objetivos</h3>
          <p>Cada chamamento apresenta seu objeto, requisitos, prazos e critérios de avaliação antes do recebimento das propostas.</p>
        </div>
        <div class="info-box">
          <h3>Fale com o Instituto</h3>
          <p>Empresas, startups e ICTs podem tirar dúvidas e entender como apresentar uma solução tecnológica ao poder público.</p>
          <div class="cards-cta">
            <a href="{{ route('contato') }}">Entrar em contato</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- QUADRO DE AVISOS -->
  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Quadro de avisos</span>
        <h2>Situação dos editais</h2>
        <p class="sub">Um retrato rápido dos chamamentos conduzidos pelo Instituto, atualizado a cada publicação.</p>
      </div>

      <div class="stats-grid">
        <div class="stat">
          <div class="num">{{ $contagem->get('aberto', 0) }}</div>
          <div class="label">Editais abertos para submissão de propostas</div>
        </div>
        <div class="stat">
          <div class="num">{{ $contagem->get('analise', 0) }}</div>
          <div class="label">Editais em análise pela comissão técnica</div>
        </div>
        <div class="stat">
          <div class="num">{{ $contagem->get('encerrado', 0) }}</div>
          <div class="label">Editais finalizados e homologados</div>
        </div>
        <div class="stat">
          <div class="num">{{ $editais->count() }}</div>
          <div class="label">Chamamentos publicados em {{ now()->year }}</div>
        </div>
      </div>

      <div class="legal-note">
        <h3>Aviso aos interessados</h3>
        <p>Retificações, erratas e respostas a pedidos de esclarecimento são publicadas no mesmo local do edital original. Confira as atualizações antes de enviar sua proposta: os prazos só mudam por aviso publicado.</p>
      </div>
    </div>
  </section>

  <!-- LISTA DE EDITAIS -->
  <section id="lista-editais">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Editais publicados</span>
        <h2>Chamamentos públicos de {{ now()->year }}</h2>
        <p class="sub">Leia o objeto, confira as datas e baixe o edital completo para conhecer requisitos, critérios de avaliação e formas de contratação.</p>
      </div>

      <div class="doc-filters" role="group" aria-label="Filtrar editais por situação">
        <button type="button" class="chip is-active" data-filter="todos" aria-pressed="true">Todos</button>
        <button type="button" class="chip" data-filter="aberto" aria-pressed="false">Abertos</button>
        <button type="button" class="chip" data-filter="analise" aria-pressed="false">Em análise</button>
        <button type="button" class="chip" data-filter="encerrado" aria-pressed="false">Encerrados</button>
      </div>

      <div class="norma-grid">
        @foreach ($editais as $edital)
          <article class="card" data-edital-status="{{ $edital['status'] }}">
            <span class="kicker"><span class="status {{ $edital['classe'] }}">{{ $edital['rotulo'] }}</span></span>
            <h3>{{ $edital['titulo'] }}</h3>
            <p>{{ $edital['resumo'] }}</p>

            <dl class="ficha">
              <div>
                <dt>Abertura</dt>
                <dd>{{ $edital['abertura']->format('d/m/Y') }}</dd>
              </div>
              <div>
                <dt>Encerramento</dt>
                <dd>{{ $edital['encerramento']->format('d/m/Y') }}</dd>
              </div>
            </dl>

            <div class="proc-cta-row">
              <a href="{{ $edital['url'] }}" class="btn {{ $edital['status'] === 'aberto' ? 'btn-primary' : 'btn-outline' }}">{{ $edital['acao'] }}</a>
            </div>
          </article>
        @endforeach
      </div>

      <div class="doc-empty" role="status">Nenhum edital encontrado para este filtro.</div>
    </div>
  </section>

  <!-- CTA FINAL -->
  <section class="final-cta">
    <div class="wrap">
      <div>
        <h2>Sua empresa tem uma solução para a gestão pública?</h2>
        <p>Fale com a equipe do Instituto, tire dúvidas sobre os próximos chamamentos e conheça o caminho para levar sua tecnologia a prefeituras e câmaras.</p>
      </div>
      <a href="{{ route('contato') }}" class="btn btn-gold">Falar com o Instituto</a>
    </div>
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
