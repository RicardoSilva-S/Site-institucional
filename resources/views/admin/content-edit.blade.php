<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Painel de edição de textos | IDTNPR</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-shell">

  <header class="admin-header">
    <div class="wrap">
      <div class="brand-row">
        <img src="{{ asset('assets/logo.png') }}" alt="IDTNPR">
        <h1>Painel de edição de textos</h1>
      </div>
      <div style="display:flex;align-items:center;gap:18px;">
        <a class="back-link" href="{{ route('admin.messages.index') }}">Mensagens recebidas</a>
        <a class="back-link" href="{{ route('home') }}">← Voltar para o site</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-text" style="color:rgba(255,255,255,0.75);">Sair ({{ auth()->user()->email }})</button>
        </form>
      </div>
    </div>
  </header>

  <div class="wrap admin-intro">
    <h2>Edite os textos do site</h2>
    <p>
      Altere o texto de qualquer campo abaixo e clique em <strong>Salvar alterações</strong>.
      As mudanças ficam salvas no banco de dados e aparecem no site imediatamente,
      para qualquer visitante — não é mais algo só deste navegador.
    </p>
  </div>

  <div class="wrap">
    @if (session('status'))
      <div class="admin-flash success">{{ session('status') }}</div>
    @endif
  </div>

  <div class="wrap admin-toolbar">
    <input type="text" id="admin-search" class="admin-search" placeholder="Buscar por um texto ou campo…">
    <div class="admin-toolbar-actions">
      <a href="{{ route('admin.content.export') }}" class="btn btn-outline btn-sm">Exportar textos (.json)</a>
      <form id="admin-reset-form" method="POST" action="{{ route('admin.content.reset') }}">
        @csrf
        <button type="submit" class="btn-text">Restaurar padrão</button>
      </form>
    </div>
  </div>

  <form id="admin-form" class="wrap" method="POST" action="{{ route('admin.content.update') }}" novalidate>
    @csrf

    @foreach ($schema as $page)
      <details class="admin-page" @if ($loop->first) open @endif>
        <summary>
          <span>{{ $page['pageLabel'] }}</span>
          <span class="admin-page-count">
            {{ collect($page['groups'])->sum(fn ($g) => count($g['fields'])) }} campos
          </span>
        </summary>

        @foreach ($page['groups'] as $group)
          <div class="admin-group">
            <h3>{{ $group['label'] }}</h3>

            @foreach ($group['fields'] as $field)
              @php $fieldId = 'field-'.str_replace('.', '-', $field['key']); @endphp
              {{-- O nome do campo usa a sintaxe fields[key] (array), não
                   "key" puro: o PHP troca pontos por underscore em nomes de
                   campo fora de colchetes, o que quebraria as keys tipo
                   "home.hero.title". Dentro de fields[...] o ponto é preservado. --}}
              <div class="admin-field @error('fields.'.$field['key']) has-error @enderror">
                <label for="{{ $fieldId }}">{{ $field['label'] }}</label>
                <div>
                  @if (!empty($field['long']))
                    <textarea id="{{ $fieldId }}" name="fields[{{ $field['key'] }}]" rows="3">{{ $currentValues[$field['key']] }}</textarea>
                  @else
                    <input type="text" id="{{ $fieldId }}" name="fields[{{ $field['key'] }}]" value="{{ $currentValues[$field['key']] }}">
                  @endif
                  @error('fields.'.$field['key'])
                    <span class="field-error">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      </details>
    @endforeach

    <div class="admin-save-bar">
      <div class="wrap">
        <p>As alterações valem para todos os visitantes do site assim que forem salvas.</p>
        <button type="submit" class="btn btn-primary btn-sm">Salvar alterações</button>
      </div>
    </div>
  </form>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
