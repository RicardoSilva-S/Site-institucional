@extends('layouts.app')

@section('title', 'Projetos e Soluções | IDTNPR')
@section('description', 'Conheça as iniciativas tecnológicas desenvolvidas pelo IDTNPR para modernizar a administração pública, prefeituras e câmaras.')

@section('content')

  {{-- HERO --}}
  <section class="hero">
    <div class="wrap hero-grid">
      <div>
        <span class="eyebrow"><span class="dot"></span> Soluções para a gestão pública</span>
        <h1>Tecnologia que transforma desafios públicos em soluções.</h1>
        <p class="lead">O IDTNPR aproxima inovação, desenvolvimento e administração pública para criar soluções acessíveis, seguras e conectadas à realidade de prefeituras e câmaras municipais.</p>
        <div class="cta-row">
          <a href="#projetos" class="btn btn-primary">Conheça as soluções</a>
          <a href="{{ route('contato') }}" class="btn btn-outline">Fale com o Instituto</a>
        </div>
        <ul class="facts">
          <li>Inovação aplicada ao serviço do cidadão</li>
          <li>Soluções desenvolvidas para necessidades reais</li>
          <li>Orientação institucional em cada etapa</li>
        </ul>
      </div>

      <!-- Ilustração editorial exclusiva: tecnologia e hub de inovação -->
      <div class="hero-visual" aria-label="Ilustração de um hub de tecnologia com código, conexões digitais e desenvolvimento de software" role="img">
        <svg viewBox="0 0 520 430" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
          <!-- círculos suaves de fundo -->
          <circle cx="372" cy="174" r="132" fill="#EDE2C7"/>
          <circle cx="372" cy="174" r="104" fill="#F4EBD7"/>

          <!-- base editorial -->
          <path d="M70 348H456" stroke="#0F2A5C" stroke-width="3" stroke-linecap="round"/>
          <path d="M112 329H414" stroke="#0F2A5C" stroke-width="3" stroke-linecap="round"/>
          <path d="M142 329V348M384 329V348" stroke="#0F2A5C" stroke-width="3"/>

          <!-- monitor / janela de software -->
          <rect x="122" y="76" width="250" height="176" rx="8" fill="#FFFFFF" stroke="#0F2A5C" stroke-width="3"/>
          <path d="M122 108H372" stroke="#0F2A5C" stroke-width="3"/>
          <circle cx="143" cy="92" r="5" fill="#B88A2B"/>
          <circle cx="160" cy="92" r="5" fill="#EDE2C7" stroke="#0F2A5C" stroke-width="1.5"/>
          <circle cx="177" cy="92" r="5" fill="#EDE2C7" stroke="#0F2A5C" stroke-width="1.5"/>

          <!-- código e terminal -->
          <path d="M156 143L174 159L156 175" fill="none" stroke="#B88A2B" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M194 181H242" stroke="#0F2A5C" stroke-width="5" stroke-linecap="round"/>
          <path d="M204 141H267M204 159H307M204 177H289" stroke="#0F2A5C" stroke-width="4" stroke-linecap="round" opacity=".72"/>
          <path d="M156 208H230M245 208H320" stroke="#0F2A5C" stroke-width="4" stroke-linecap="round" opacity=".55"/>

          <!-- suporte do monitor -->
          <path d="M225 252V291H269V252" fill="#F4EBD7" stroke="#0F2A5C" stroke-width="3"/>
          <path d="M194 307H300L285 291H209L194 307Z" fill="#FFFFFF" stroke="#0F2A5C" stroke-width="3" stroke-linejoin="round"/>

          <!-- hub de conexões -->
          <circle cx="402" cy="123" r="27" fill="#FFFFFF" stroke="#0F2A5C" stroke-width="3"/>
          <circle cx="402" cy="123" r="9" fill="#EDE2C7" stroke="#B88A2B" stroke-width="3"/>
          <path d="M382 103L350 74M422 103L451 78M378 143L344 169M426 143L456 169" fill="none" stroke="#0F2A5C" stroke-width="3" stroke-linecap="round"/>
          <circle cx="346" cy="72" r="8" fill="#B88A2B" stroke="#0F2A5C" stroke-width="2"/>
          <circle cx="453" cy="77" r="8" fill="#FFFFFF" stroke="#0F2A5C" stroke-width="2"/>
          <circle cx="342" cy="171" r="8" fill="#FFFFFF" stroke="#0F2A5C" stroke-width="2"/>
          <circle cx="458" cy="171" r="8" fill="#B88A2B" stroke="#0F2A5C" stroke-width="2"/>

          <!-- sinal de inovação -->
          <path d="M402 178V242" stroke="#0F2A5C" stroke-width="3" stroke-linecap="round"/>
          <path d="M402 179L445 191L402 204Z" fill="#B88A2B" stroke="#0F2A5C" stroke-width="2" stroke-linejoin="round"/>
          <path d="M384 263H420M391 276H413" stroke="#0F2A5C" stroke-width="3" stroke-linecap="round"/>
        </svg>
      </div>
    </div>
  </section>

  {{-- IMPACTO --}}
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Impacto e alcance</span>
        <h2>Projetos pensados para produzir resultado público.</h2>
        <p class="sub">Cada iniciativa conecta diagnóstico, tecnologia e orientação para apoiar decisões mais eficientes e transparentes.</p>
      </div>

      <div class="stats-grid">
        <div class="stat">
          <div class="num">4</div>
          <div class="label">frentes de soluções para municípios</div>
        </div>
        <div class="stat">
          <div class="num">3</div>
          <div class="label">áreas integradas: cidadão, gestão e legislativo</div>
        </div>
        <div class="stat">
          <div class="num">100%</div>
          <div class="label">foco na realidade da administração pública</div>
        </div>
        <div class="stat">
          <div class="num">1</div>
          <div class="label">Instituto para orientar o caminho da inovação</div>
        </div>
      </div>

      <div class="rite-strip">
        <div class="rite-stage"><div class="t">Diagnóstico</div><div class="s">Entender o desafio local</div></div>
        <div class="rite-stage"><div class="t">Desenho</div><div class="s">Definir a solução adequada</div></div>
        <div class="rite-stage"><div class="t">Tecnologia</div><div class="s">Aplicar inovação com propósito</div></div>
        <div class="rite-stage"><div class="t">Orientação</div><div class="s">Apoiar a contratação segura</div></div>
        <div class="rite-stage"><div class="t">Resultado</div><div class="s">Melhorar o serviço público</div></div>
      </div>
    </div>
  </section>

  {{-- PROJETOS E SOLUÇÕES --}}
  <section id="projetos">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Portfólio institucional</span>
        <h2>Soluções para desafios reais da administração municipal.</h2>
        <p class="sub">Conheça as iniciativas do IDTNPR e identifique quais delas podem contribuir para o seu município.</p>
      </div>

      <div class="cards-grid">
        <article class="card">
          <span class="kicker"><span class="status publicado">Implementado</span></span>
          <h3>Totem de Autoatendimento</h3>
          <p><strong>Frente:</strong> Atendimento ao cidadão</p>
          <p>Reduz filas e facilita o acesso da população a serviços e informações municipais em pontos estratégicos de atendimento.</p>
          <p><strong>Tecnologia:</strong> autoatendimento digital, interface acessível e integração com serviços públicos.</p>
          <a href="{{ route('contato') }}" class="link">Conhecer a solução</a>
        </article>

        <article class="card">
          <span class="kicker"><span class="status">Em expansão</span></span>
          <h3>Alô Câmara</h3>
          <p><strong>Frente:</strong> Participação popular e legislativo</p>
          <p>Cria um canal direto entre a Câmara Municipal e os moradores para aproximar a população do trabalho dos vereadores.</p>
          <p><strong>Tecnologia:</strong> comunicação digital, registro de demandas e acesso simplificado à informação.</p>
          <a href="{{ route('contato') }}" class="link">Conhecer a solução</a>
        </article>

        <article class="card">
          <span class="kicker"><span class="status">Consultoria</span></span>
          <h3>Lei Municipal de Inovação</h3>
          <p><strong>Frente:</strong> Marco legal e segurança jurídica</p>
          <p>Apoia o município na criação de um ambiente institucional capaz de estimular inovação, parcerias e modernização dos serviços.</p>
          <p><strong>Tecnologia:</strong> diagnóstico normativo, estruturação regulatória e orientação para políticas públicas.</p>
          <a href="{{ route('marco-legal') }}" class="link">Conhecer o marco legal</a>
        </article>

        <article class="card">
          <span class="kicker"><span class="status elaboracao">Fase piloto</span></span>
          <h3>Gestão de Manutenção Municipal</h3>
          <p><strong>Frente:</strong> Gestão municipal e operação</p>
          <p>Organiza solicitações, ordens de serviço e históricos de manutenção para dar mais previsibilidade à operação municipal.</p>
          <p><strong>Tecnologia:</strong> gestão de chamados, acompanhamento de ativos e painéis de controle.</p>
          <a href="{{ route('contato') }}" class="link">Conhecer o projeto</a>
        </article>

        <article class="card">
          <span class="kicker"><span class="status">Desenvolvimento</span></span>
          <h3>Mobilidade e Frota Pública</h3>
          <p><strong>Frente:</strong> Mobilidade, frota e eficiência</p>
          <p>Ajuda o município a acompanhar veículos, deslocamentos e necessidades de manutenção, apoiando uma operação mais econômica e organizada.</p>
          <p><strong>Tecnologia:</strong> monitoramento de ativos, indicadores operacionais e dados para tomada de decisão.</p>
          <a href="{{ route('contato') }}" class="link">Conhecer o projeto</a>
        </article>
      </div>
    </div>
  </section>

  {{-- CTA FINAL --}}
  <section class="final-cta">
    <div class="wrap">
      <div>
        <h2>Seu município também pode inovar com segurança.</h2>
        <p>Converse com o IDTNPR para identificar o desafio, avaliar a solução mais adequada e entender os próximos passos.</p>
      </div>
      <a href="{{ route('contato') }}" class="btn btn-gold">Solicitar diagnóstico gratuito</a>
    </div>
  </section>

@endsection
