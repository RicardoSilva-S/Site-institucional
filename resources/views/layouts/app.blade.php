<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@php
  // Valores únicos de SEO: cada página define @section('title'), @section('description'),
  // e opcionalmente @section('og_image') (URL absoluta ou asset()) e @section('robots').
  $seoTitle       = trim($__env->yieldContent('title')) ?: 'IDTNPR';
  $seoDescription = trim($__env->yieldContent('description')) ?: 'O IDTNPR é uma instituição de ciência e tecnologia sem fins lucrativos que reúne soluções tecnológicas para prefeituras e câmaras municipais e indica o caminho jurídico para contratá-las.';
  $seoImage       = trim($__env->yieldContent('og_image')) ?: asset('assets/og-image.jpg');
  $seoRobots      = trim($__env->yieldContent('robots')) ?: 'index, follow';
  $seoUrl         = url()->current();
@endphp
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="robots" content="{{ $seoRobots }}">
<link rel="canonical" href="{{ $seoUrl }}">
<meta name="theme-color" content="#0F2A5C">
{{-- Ícones: aba do navegador, favoritos e tela inicial do celular --}}
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

{{-- Open Graph: pré-visualização no WhatsApp, LinkedIn e Facebook --}}
<meta property="og:type" content="website">
<meta property="og:site_name" content="IDTNPR">
<meta property="og:locale" content="pt_BR">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $seoUrl }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="IDTNPR - Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense">

{{-- Twitter/X (também usado por alguns apps como fallback) --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">

{{-- Dados estruturados: ajuda o Google a identificar a organização --}}
<script type="application/ld+json">
{!! json_encode([
    '@context'      => 'https://schema.org',
    '@type'         => 'Organization',
    'name'          => 'IDTNPR',
    'alternateName' => 'Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense',
    'url'           => url('/'),
    'logo'          => asset('assets/logo.png'),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
</script>

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
    {{-- Logo do topo: acima da dobra, então SEM loading="lazy" --}}
    <a href="{{ route('home') }}" class="brand">
      <img src="{{ asset('assets/logo.png') }}" alt="IDTNPR - Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense" fetchpriority="high">
    </a>

    <nav class="primary" id="menu-principal" aria-label="Navegação principal">
      <ul>
        <li><a class="top-link" href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>@content('shared.nav.inicio')</a></li>
        <li class="has-sub">
          <a class="top-link" href="{{ route('institucional') }}" @if (request()->routeIs('institucional', 'marco-legal')) aria-current="page" @endif>@content('shared.nav.institucional')</a>
          <div class="sub-panel">
            <a href="{{ route('institucional') }}">Quem somos</a>
            <a href="{{ route('institucional') }}#linha-do-tempo">Linha do tempo</a>
            <a href="{{ route('institucional') }}#governanca">Governança</a>
            <a href="{{ route('marco-legal') }}">Marco Legal</a>
          </div>
        </li>
        <li><a class="top-link" href="{{ route('atuacao') }}" @if (request()->routeIs('atuacao')) aria-current="page" @endif>@content('shared.nav.atuacao')</a></li>
        <li><a class="top-link" href="{{ route('projetos') }}" @if (request()->routeIs('projetos')) aria-current="page" @endif>@content('shared.nav.projetos')</a></li>
        <li><a class="top-link" href="{{ route('editais') }}" @if (request()->routeIs('editais')) aria-current="page" @endif>@content('shared.nav.editais')</a></li>
        <li><a class="top-link" href="{{ route('transparencia') }}" @if (request()->routeIs('transparencia')) aria-current="page" @endif>@content('shared.nav.transparencia')</a></li>
        <li><a class="top-link" href="{{ route('contato') }}" @if (request()->routeIs('contato')) aria-current="page" @endif>@content('shared.nav.contato')</a></li>
      </ul>
    </nav>

    <div style="display:flex;align-items:center;gap:12px;">
      {{-- nav-cta: a classe esconde o botão em telas muito pequenas (style.css, max-width:480px) --}}
      <a href="{{ route('contato') }}" class="btn btn-primary nav-cta">@content('shared.nav.cta')</a>
      <button type="button" class="menu-toggle" aria-label="Abrir menu" aria-expanded="false" aria-controls="menu-principal">☰</button>
    </div>
  </div>
</header>

{{-- tabindex="-1": o link "Pular para o conteúdo" consegue mover o foco para cá --}}
<main id="conteudo" tabindex="-1">
  {{-- Banners cadastrados no painel (/adm/banners) para esta página. --}}
  @include('partials.banner')
  @yield('content')
</main>

<footer>
  <div class="wrap">
    <div class="footer-grid">
      <div class="footer-about">
        {{-- Rodapé fica abaixo da dobra: carrega só quando o usuário chega perto --}}
        <img src="{{ asset('assets/logo.png') }}" alt="IDTNPR" loading="lazy" decoding="async">
        <p>@content('shared.footer.about')</p>
      </div>

      <div>
        <h2>@content('shared.footer.col1.title')</h2>
        <ul>
          <li><a href="{{ route('institucional') }}">Quem somos</a></li>
          <li><a href="{{ route('institucional') }}#linha-do-tempo">Linha do tempo</a></li>
          <li><a href="{{ route('institucional') }}#governanca">Governança</a></li>
          <li><a href="{{ route('marco-legal') }}">Marco Legal</a></li>
        </ul>
      </div>

      <div>
        <h2>@content('shared.footer.col2.title')</h2>
        <ul>
          <li><a href="{{ route('projetos') }}">Projetos e produtos</a></li>
          <li><a href="{{ route('atuacao') }}">Frentes de atuação</a></li>
          <li><a href="{{ route('editais') }}">Editais e chamamentos</a></li>
          <li><a href="{{ route('contato') }}#diagnostico">Diagnóstico gratuito</a></li>
        </ul>
      </div>

      <div>
        <h2>@content('shared.footer.col3.title')</h2>
        <ul>
          <li><a href="{{ route('transparencia') }}">Portal da Transparência</a></li>
          <li><a href="{{ route('transparencia') }}">Documentos institucionais</a></li>
          <li><a href="{{ route('contato') }}#ouvidoria">Ouvidoria</a></li>
          <li><a href="{{ route('privacidade') }}">LGPD e Privacidade</a></li>
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
