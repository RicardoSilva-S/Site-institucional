@extends('layouts.app')

@section('title', 'Portal da Transparência | IDTNPR')
@section('description', 'Documentos institucionais do IDTNPR: estatuto, atas registradas, regimento interno, CNPJ, normativos, parcerias e prestação de contas. Solicite o envio de qualquer documento.')

@php
  /*
   * Lista de documentos: dado estruturado, não "texto" do site — por isso
   * fica aqui como array PHP (como no arquivo do colega), e não em
   * config/site_content.php / @content(). Um controller pode passar
   * $secoes e $atualizacao prontos (view('site.transparencia', compact('secoes','atualizacao')))
   * no dia em que isso vier de um lugar mais dinâmico (ex.: banco de dados).
   */
  $atualizacao = $atualizacao ?? 'Setembro de 2026';
  $whatsapp = '5544998083001';
  $secoes = $secoes ?? [
    ['id' => 'institucional', 'titulo' => 'Institucional', 'subtitulo' => 'Documentos de constituição e registro', 'docs' => [
      ['nome' => 'Estatuto Social consolidado', 'detalhe' => 'Registrado no RTDPJ de Sarandi/PR', 'status' => 'publicado'],
      ['nome' => 'Ata de Fundação', 'detalhe' => '11/07/2025 · Registro nº 508', 'status' => 'publicado'],
      ['nome' => 'Ata da Assembleia Geral Ordinária nº 01/2026', 'detalhe' => '02/01/2026 · Registro nº 508/01', 'status' => 'publicado'],
      ['nome' => 'Ata da Assembleia Geral Extraordinária nº 02/2026', 'detalhe' => '02/01/2026 · Registro nº 508/02', 'status' => 'publicado'],
      ['nome' => 'Regimento Interno', 'detalhe' => '02/01/2026', 'status' => 'publicado'],
      ['nome' => 'Comprovante de Inscrição no CNPJ', 'detalhe' => '64.039.593/0001-82', 'status' => 'publicado'],
    ]],
    ['id' => 'governanca', 'titulo' => 'Governança e gestão', 'subtitulo' => 'Composição, mandatos e decisões', 'docs' => [
      ['nome' => 'Composição da Diretoria Executiva e do Conselho', 'status' => 'publicado'],
      ['nome' => 'Atas de reunião da Diretoria Executiva', 'status' => 'publicacao'],
      ['nome' => 'Atas de reunião do Conselho Fiscal e Consultivo', 'status' => 'publicacao'],
    ]],
    ['id' => 'normativos', 'titulo' => 'Normativos internos', 'subtitulo' => 'Regras que o Instituto edita para si mesmo', 'docs' => [
      ['nome' => 'Regulamento de Contratações', 'status' => 'elaboracao'],
      ['nome' => 'Regulamento de Parcerias e Oportunidades de Negócio', 'status' => 'elaboracao'],
      ['nome' => 'Código de Ética, Conduta e Integridade', 'status' => 'elaboracao'],
      ['nome' => 'Política de Conflito de Interesses', 'status' => 'elaboracao'],
      ['nome' => 'Política de Inovação e Política de Propriedade Intelectual', 'status' => 'elaboracao'],
    ]],
    ['id' => 'parcerias', 'titulo' => 'Parcerias e contratos', 'subtitulo' => 'Termos e acordos firmados pelo Instituto', 'docs' => [
      ['nome' => 'Termo de Cooperação Técnica nº 001/2026 com a Compaxis Tecnologia Ltda', 'detalhe' => '05/08/2026 · sem transferência de recursos', 'status' => 'publicado'],
    ]],
    ['id' => 'contas', 'titulo' => 'Prestação de contas', 'subtitulo' => 'Demonstrativos e pareceres', 'docs' => [
      ['nome' => 'Demonstrações contábeis do exercício', 'status' => 'publicacao'],
      ['nome' => 'Parecer do Conselho Fiscal', 'status' => 'publicacao'],
      ['nome' => 'Relatório Anual de Atividades', 'status' => 'publicacao'],
    ]],
  ];
  $rotulos = ['publicado' => 'Disponível', 'publicacao' => 'Em publicação', 'elaboracao' => 'Em elaboração'];
  $zap = fn ($doc) => 'https://wa.me/' . $whatsapp . '?text=' . rawurlencode('Olá! Gostaria de receber o seguinte documento do IDTNPR: ' . $doc);
@endphp

@section('content')

  <!-- HERO -->
  <section class="page-hero">
    <div class="wrap">
      <h1>@content('transparencia.hero.title')</h1>
      <p class="lead">@content('transparencia.hero.lead')</p>
      <div class="page-meta">
        <div class="meta-chip"><span class="k">Última atualização</span><span class="v">{{ $atualizacao }}</span></div>
        <div class="meta-chip"><span class="k">Pedidos de informação</span><a class="v" href="mailto:faleconosco@idtnpr.org.br">faleconosco@idtnpr.org.br</a></div>
      </div>
    </div>
  </section>

  <!-- SOLICITAÇÃO -->
  <section style="padding:36px 0 20px;">
    <div class="wrap">
      <div class="cta-panel">
        <div>
          <h2>@content('transparencia.cta.title')</h2>
          <p>@content('transparencia.cta.text')</p>
        </div>
        <div class="cta-row">
          <a class="btn btn-primary" href="{{ $zap('documentos institucionais') }}" target="_blank" rel="noopener">@content('transparencia.cta.btn_whatsapp')</a>
          <a class="btn btn-outline" href="mailto:faleconosco@idtnpr.org.br?subject={{ rawurlencode('Solicitação de documentos institucionais') }}">@content('transparencia.cta.btn_email')</a>
        </div>
      </div>
    </div>
  </section>

  <!-- DOCUMENTOS -->
  <section style="padding-top:48px;">
    <div class="wrap">
      <div class="doc-filters" role="search">
        <input type="search" id="doc-busca" placeholder="Buscar documento" aria-label="Buscar documento">
        <button type="button" class="chip is-active" data-filter="todos">Todos</button>
        @foreach ($secoes as $secao)
          <button type="button" class="chip" data-filter="{{ $secao['id'] }}">{{ $secao['titulo'] }}</button>
        @endforeach
      </div>

      @foreach ($secoes as $secao)
        <div class="doc-section" id="{{ $secao['id'] }}" data-section="{{ $secao['id'] }}">
          <div class="doc-section-head">
            <h3>{{ $secao['titulo'] }}</h3>
            <span>{{ $secao['subtitulo'] }}</span>
          </div>
          <ul class="doc-list">
            @foreach ($secao['docs'] as $doc)
              <li class="doc-item" data-name="{{ \Illuminate\Support\Str::lower($doc['nome']) }}">
                <div>
                  <div class="doc-name">{{ $doc['nome'] }}</div>
                  @isset($doc['detalhe'])<div class="doc-detail">{{ $doc['detalhe'] }}</div>@endisset
                </div>
                <div class="doc-side">
                  @if ($doc['status'] === 'publicado')
                    <a class="btn btn-outline" href="{{ $zap($doc['nome']) }}" target="_blank" rel="noopener">Solicitar</a>
                  @else
                    <span class="status {{ $doc['status'] }}">{{ $rotulos[$doc['status']] ?? $doc['status'] }}</span>
                  @endif
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach

      <p class="doc-empty" id="doc-vazio">Nenhum documento encontrado para essa busca.</p>

      <div class="doc-note">
        <h3>@content('transparencia.editais.title')</h3>
        <p>@content('transparencia.editais.text')</p>
        {{-- Editais ainda não tem rota própria — aponta pra rota real quando existir em routes/web.php. --}}
        <a class="btn btn-primary" href="#">@content('transparencia.editais.btn')</a>
      </div>
    </div>
  </section>

  <!-- PEDIDOS DE INFORMAÇÃO -->
  <section class="alt">
    <div class="wrap transp-grid">
      <div>
        <span class="section-head kicker" style="display:block;">@content('transparencia.pedidos.kicker')</span>
        <h2>@content('transparencia.pedidos.title')</h2>
      </div>
      <p style="color:var(--ink-soft);font-size:16.5px;">
        @content('transparencia.pedidos.text')
        <a href="mailto:faleconosco@idtnpr.org.br" style="color:var(--navy);font-weight:600;">faleconosco@idtnpr.org.br</a>
        ou pela <a href="{{ route('contato') }}#ouvidoria" style="color:var(--navy);font-weight:600;">Ouvidoria</a>. Respondemos em até 20 dias úteis.
      </p>
    </div>
  </section>

@endsection

@push('scripts')
  <script src="{{ asset('js/transparencia.js') }}"></script>
@endpush
