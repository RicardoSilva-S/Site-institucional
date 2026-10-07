<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'IDTNPR')</title>
<meta name="description" content="@yield('description', 'O IDTNPR é uma instituição de ciência e tecnologia sem fins lucrativos que reúne soluções tecnológicas para prefeituras e câmaras municipais e indica o caminho jurídico para contratá-las.')">
<meta name="theme-color" content="#0F2A5C">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stack('styles')
</head>
<body>

<a href="#conteudo" class="skip-link">Pular para o conteúdo</a>

<header>
  <div class="wrap nav-row">
    <a href="{{ route('home') }}" class="brand">
      <img src="{{ asset('assets/logo.png') }}" alt="IDTNPR - Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense">
    </a>

    {{-- Projetos e Editais ainda não têm rota própria — Início,
         Institucional, Marco Legal, Atuação, Contato e Transparência já foram
         migrados para Blade. Aponte para a rota real assim que a página
         correspondente existir em routes/web.php. --}}
    <nav class="primary" aria-label="Navegação principal">
      <ul>
        <li><a class="top-link" href="{{ route('home') }}">@content('shared.nav.inicio')</a></li>
        <li class="has-sub">
          <a class="top-link" href="{{ route('institucional') }}">@content('shared.nav.institucional')</a>
          <div class="sub-panel">
            <a href="{{ route('institucional') }}">Quem somos</a>
            <a href="{{ route('institucional') }}#linha-do-tempo">Linha do tempo</a>
            <a href="{{ route('institucional') }}#governanca">Governança</a>
            <a href="{{ route('marco-legal') }}">Marco Legal</a>
          </div>
        </li>
        <li><a class="top-link" href="{{ route('atuacao') }}">@content('shared.nav.atuacao')</a></li>
        <li><a class="top-link" href="#">@content('shared.nav.projetos')</a></li>
        <li><a class="top-link" href="#">@content('shared.nav.editais')</a></li>
        <li><a class="top-link" href="{{ route('transparencia') }}">@content('shared.nav.transparencia')</a></li>
        <li><a class="top-link" href="{{ route('contato') }}">@content('shared.nav.contato')</a></li>
      </ul>
    </nav>

    <div style="display:flex;align-items:center;gap:12px;">
      <a href="#" class="btn btn-primary">@content('shared.nav.cta')</a>
      <button class="menu-toggle" aria-label="Abrir menu" aria-expanded="false">☰</button>
    </div>
  </div>
</header>

<main id="conteudo">
  {{-- Banners cadastrados no painel (/adm/banners) para esta página. --}}
  @include('partials.banner')
  @yield('content')
</main>

<footer>
  <div class="wrap">
    <div class="footer-grid">
      <div class="footer-about">
        <img src="{{ asset('assets/logo.png') }}" alt="IDTNPR">
        <p>@content('shared.footer.about')</p>
      </div>

      <div>
        <h4>@content('shared.footer.col1.title')</h4>
        <ul>
          <li><a href="{{ route('institucional') }}">Quem somos</a></li>
          <li><a href="{{ route('institucional') }}#linha-do-tempo">Linha do tempo</a></li>
          <li><a href="{{ route('institucional') }}#governanca">Governança</a></li>
          <li><a href="{{ route('marco-legal') }}">Marco Legal</a></li>
        </ul>
      </div>

      <div>
        <h4>@content('shared.footer.col2.title')</h4>
        <ul>
          <li><a href="#">Projetos e produtos</a></li>
          <li><a href="{{ route('atuacao') }}">Frentes de atuação</a></li>
          <li><a href="#">Editais e chamamentos</a></li>
          <li><a href="#">Diagnóstico gratuito</a></li>
        </ul>
      </div>

      <div>
        <h4>@content('shared.footer.col3.title')</h4>
        <ul>
          <li><a href="{{ route('transparencia') }}">Portal da Transparência</a></li>
          <li><a href="{{ route('transparencia') }}">Documentos institucionais</a></li>
          <li><a href="{{ route('contato') }}#ouvidoria">Ouvidoria</a></li>
          <li><a href="#">LGPD e Privacidade</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>@content('shared.footer.bottom.left')</span>
      <span>@content('shared.footer.bottom.right')</span>
    </div>
  </div>
  @extraTexts('shared.footer')
</footer>

<script src="{{ asset('js/site.js') }}"></script>
@stack('scripts')
</body>
</html>
