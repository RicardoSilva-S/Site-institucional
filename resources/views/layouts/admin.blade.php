<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Painel') | Painel IDTNPR</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-shell">

<div class="admin-layout">

  {{-- Menu lateral: uma entrada por página do site + Banners --}}
  <aside class="admin-sidebar">
    <div class="admin-sidebar__brand">
      <img src="{{ asset('assets/logo.png') }}" alt="IDTNPR">
      <span>Painel administrativo</span>
    </div>

    <button type="button" class="admin-sidebar__toggle" aria-expanded="false">☰ Menu</button>

    <nav class="admin-sidebar__nav" aria-label="Menu do painel">
      <p class="admin-sidebar__title">Páginas do site</p>
      <ul>
        @foreach ($adminPages as $item)
          <li>
            <a href="{{ route('admin.pages.show', $item['page']) }}"
               class="{{ request()->routeIs('admin.pages.show') && request()->route('page') === $item['page'] ? 'is-active' : '' }}">
              {{ $item['pageLabel'] }}
            </a>
          </li>
        @endforeach
      </ul>
      <p class="admin-sidebar__title">Mídia</p>
      <ul>
        <li>
          <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'is-active' : '' }}">
            Banners
          </a>
        </li>
      </ul>
    </nav>

    <div class="admin-sidebar__footer">
      <a href="{{ route('home') }}" target="_blank" rel="noopener">Ver site ↗</a>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Sair</button>
      </form>
      <small>{{ auth()->user()->email }}</small>
    </div>
  </aside>

  <main class="admin-main">
    @if (session('status'))
      <div class="admin-flash success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
      <div class="admin-flash error">{{ $errors->first() }}</div>
    @endif

    @yield('content')
  </main>

</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>