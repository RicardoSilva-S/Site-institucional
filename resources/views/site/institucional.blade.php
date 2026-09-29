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

  .team-card__body {
    padding: 28px;
  }
</style>
@endpush

@section('content')
  <section class="page-hero">
    <div class="wrap">
      <span class="eyebrow"><span class="dot"></span> Conheça o IDTNPR</span>
      <h1>Institucional</h1>
      <p class="lead">Quem somos, de onde viemos e como nos organizamos.</p>
    </div>
  </section>

  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Quem somos</span>
        <h2>Uma instituição de ciência e tecnologia a serviço da gestão pública</h2>
        <p class="sub">O Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense (IDTNPR) é uma associação civil de direito privado, sem fins lucrativos, com sede em Sarandi, Paraná.</p>
      </div>
      <div class="info-box">
        <p>Atuamos junto a prefeituras, câmaras municipais, consórcios públicos e demais entidades da Administração Pública, apoiando a modernização administrativa, a transformação digital e a estruturação de políticas de ciência, tecnologia e inovação.</p>
        <p style="margin-top:14px;">Nosso objeto social contempla a pesquisa aplicada de caráter tecnológico e o desenvolvimento de produtos, serviços e processos, o que nos enquadra como Instituição de Ciência e Tecnologia nos termos do art. 2º, inciso V, da Lei nº 10.973/2004, o Marco Legal de Ciência, Tecnologia e Inovação.</p>
      </div>
      <div class="qa-block" style="margin-top:24px;">
        <p class="question">Missão</p>
        <p class="answer">Fomentar o desenvolvimento tecnológico e a inovação em entidades públicas e privadas, com transparência, legalidade e compromisso com o interesse público.</p>
        <p class="question" style="margin-top:24px;">Visão</p>
        <p class="answer">Ser referência em inovação e tecnologia aplicada ao setor público, reconhecida pela excelência técnica e pelo impacto real na modernização da gestão pública.</p>
        <p class="question" style="margin-top:24px;">Princípios</p>
        <p class="answer">Legalidade · Impessoalidade · Moralidade · Publicidade · Eficiência · Transparência · Integridade institucional · Interesse público</p>
      </div>
    </div>
  </section>

  <section class="alt" id="linha-do-tempo">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Nossa história</span>
        <h2>Como o Instituto chegou até aqui</h2>
        <p class="sub">A história do IDTNPR começa com a escuta de gestores públicos e a percepção de um desafio comum: acompanhar o ritmo da tecnologia e da inovação no cotidiano da gestão.</p>
      </div>
      <div class="stats-copy" style="margin-top:0;">
        <p>Essas conversas foram o embrião de uma ideia. Pessoas com experiência no setor público, na tecnologia e na gestão começaram a discutir caminhos para mudar essa realidade e moldaram, a muitas mãos, o que o Instituto viria a ser.</p>
        <p>Sarandi/PR foi escolhida como sede e ponto de partida para uma atuação que mira municípios, autarquias e entidades públicas de toda a região e do país. O que segue é o registro dos passos já dados.</p>
      </div>
      <div class="steps-track" style="margin-top:36px;">
        <article class="step"><span class="num">1</span><h3>Jul · 2025</h3><p>Constituição do Instituto em assembleia de fundação, com aprovação do Estatuto Social e eleição da primeira Diretoria.</p></article>
        <article class="step"><span class="num">2</span><h3>Set · 2025</h3><p>Inscrição no Cadastro Nacional da Pessoa Jurídica, habilitando o Instituto a firmar instrumentos e operar formalmente.</p></article>
        <article class="step"><span class="num">3</span><h3>Jan · 2026</h3><p>Eleição da Diretoria Executiva e do Conselho Fiscal e Consultivo, com aprovação do Regimento Interno.</p></article>
        <article class="step"><span class="num">4</span><h3>2026</h3><p>Primeira entrega técnica: elaboração de minuta para a Política Municipal de Ciência, Tecnologia e Inovação de Sarandi.</p></article>
        <article class="step"><span class="num">5</span><h3>Ago · 2026</h3><p>Primeira parceria com desenvolvedora, inaugurando a carteira de soluções tecnológicas do Instituto.</p></article>
      </div>
    </div>
  </section>

  <section id="governanca">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Governança</span>
        <h2>Estrutura institucional</h2>
        <p class="sub">O IDTNPR é administrado por uma Diretoria Executiva e fiscalizado por um Conselho Fiscal e Consultivo, com sede em Sarandi, no Paraná.</p>
      </div>
      <h3 style="margin-bottom:18px;">Diretoria Executiva</h3>
      <div class="cards-grid">
        <article class="card team-card">
          <img src="{{ asset('assets/equipe/jonny.jpg') }}" alt="Jonny de Souza Ribeiro" loading="lazy">
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
      <h3 style="margin:42px 0 18px;">Conselho Fiscal e Consultivo</h3>
      <div class="cards-grid">
        <article class="card"><span class="kicker">Presidente do conselho</span><h3>Vinicius Cancian</h3></article>
        <article class="card"><span class="kicker">Conselheiro fiscal</span><h3>Anderson de Jesus Ciriaco Lopes</h3></article>
        <article class="card"><span class="kicker">Conselheiro consultivo</span><h3>Walmir Rafael da Silva</h3></article>
      </div>
    </div>
  </section>

  <section class="alt">
    <div class="wrap">
      <div class="problem-grid">
        <div class="section-head" style="margin-bottom:0;">
          <span class="kicker">Marco legal</span>
          <h2>A base jurídica da nossa atuação</h2>
          <p class="sub">Toda cooperação entre o Instituto e uma entidade pública se apoia em norma expressa, e cada situação pede um instrumento diferente.</p>
          <a href="{{ route('marco-legal') }}" class="btn btn-outline" style="margin-top:26px;">Ver o Marco Legal</a>
        </div>
        <div class="cards-grid" style="grid-template-columns:1fr 1fr;">
          <article class="card"><span class="kicker">Orientação</span><h3>Seis instrumentos</h3><p>Um mapa de qual caminho legal se aplica a cada situação.</p></article>
          <article class="card"><span class="kicker">Documentação</span><h3>Minutas prontas</h3><p>Instrumentos e checklists processuais para a Procuradoria.</p></article>
        </div>
      </div>
    </div>
  </section>

  <section class="final-cta">
    <div class="wrap">
      <div>
        <h2>Documentos institucionais</h2>
        <p>Estatuto Social, atas registradas, regimento interno, normativos e prestação de contas.</p>
      </div>
      <a href="#" class="btn btn-gold">Portal da Transparência</a>
    </div>
  </section>
@endsection
