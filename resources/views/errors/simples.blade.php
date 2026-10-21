{{-- Layout das páginas de erro do servidor (500, 503 e 419).
     Diferente do layouts.app, NÃO usa o banco de dados (nada de @content,
     menu editável nem banners): se o erro for justamente no banco, a página
     de erro continua aparecendo. Usa só o style.css do site. --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title') | IDTNPR</title>
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#0F2A5C">
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header>
  <div class="wrap nav-row">
    <a href="{{ url('/') }}" class="brand">
      <img src="{{ asset('assets/logo.png') }}" alt="IDTNPR - Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense">
    </a>
  </div>
</header>

<main id="conteudo">
  <section class="page-hero">
    <div class="wrap">
      <span class="eyebrow"><span class="dot" aria-hidden="true"></span> @yield('code')</span>
      <h1>@yield('heading')</h1>
      <p class="lead">@yield('message')</p>
      <div class="cta-row">
        @yield('actions')
      </div>
    </div>
  </section>
</main>

</body>
</html>