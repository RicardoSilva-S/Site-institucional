{{-- Carrossel de banners do topo. Não mostra nada se a página não tiver
     banners ativos (o topo continua como era). Dados vêm do View Composer
     em App\Providers\AppServiceProvider. --}}
@if ($banners->isNotEmpty())
  <section class="banner-slider" aria-roledescription="carrossel" aria-label="Destaques">
    @foreach ($banners as $banner)
      <div class="banner-slide{{ $loop->first ? ' is-active' : '' }}" aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
        <img src="{{ $banner->imageUrl() }}" alt="{{ $banner->title }}" @unless($loop->first) loading="lazy" @endunless>
        @if ($banner->title || $banner->subtitle)
          <div class="banner-slide__content">
            <div class="wrap">
              @if ($banner->title)<h2>{{ $banner->title }}</h2>@endif
              @if ($banner->subtitle)<p>{{ $banner->subtitle }}</p>@endif
              @if ($banner->link)
                <a href="{{ $banner->link }}" class="btn btn-gold">Saiba mais</a>
              @endif
            </div>
          </div>
        @elseif ($banner->link)
          <a href="{{ $banner->link }}" class="banner-slide__link" aria-label="Abrir banner"></a>
        @endif
      </div>
    @endforeach

    @if ($banners->count() > 1)
      <button type="button" class="banner-nav banner-nav--prev" aria-label="Banner anterior">‹</button>
      <button type="button" class="banner-nav banner-nav--next" aria-label="Próximo banner">›</button>
      <div class="banner-dots">
        @foreach ($banners as $banner)
          <button type="button" class="{{ $loop->first ? 'is-active' : '' }}" aria-label="Ir para o banner {{ $loop->iteration }}"></button>
        @endforeach
      </div>
    @endif
  </section>
@endif