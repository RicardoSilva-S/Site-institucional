{{-- Carrossel de banners do topo. Não mostra nada se a página não tiver
     banners ativos (o topo continua como era). Dados vêm do View Composer
     em App\Providers\AppServiceProvider.

     Banners "desktop" e "mobile" viram dois carrosséis: o mobile só aparece
     no celular. Se a página não tiver banner mobile, o desktop aparece em
     todas as telas. O título mostrado é o "display_title"; o "title" é só um
     nome interno do painel. --}}
@php
  $grupos = [
    'desktop' => $banners->reject(function ($banner) { return $banner->isMobile(); })->values(),
    'mobile' => $banners->filter(function ($banner) { return $banner->isMobile(); })->values(),
  ];
@endphp

@foreach ($grupos as $versao => $lista)
  @if ($lista->isNotEmpty())
    @php $proporcao = $lista->first()->ratio(); @endphp
    <section class="banner-slider banner-slider--{{ $versao }}{{ $proporcao ? ' banner-slider--ratio' : '' }}{{ $versao === 'desktop' && $grupos['mobile']->isNotEmpty() ? ' banner-slider--has-mobile' : '' }}"
             @if ($proporcao) style="aspect-ratio: {{ $proporcao }};" @endif
             aria-roledescription="carrossel" aria-label="Destaques">
      @foreach ($lista as $banner)
        <div class="banner-slide{{ $loop->first ? ' is-active' : '' }}" aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
          <img src="{{ $banner->imageUrl() }}" alt="{{ $banner->display_title }}" @unless($loop->first) loading="lazy" @endunless>
          @if ($banner->display_title || $banner->subtitle)
            <div class="banner-slide__content">
              <div class="wrap">
                @if ($banner->display_title)<h2>{{ $banner->display_title }}</h2>@endif
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

      @if ($lista->count() > 1)
        <button type="button" class="banner-nav banner-nav--prev" aria-label="Banner anterior">‹</button>
        <button type="button" class="banner-nav banner-nav--next" aria-label="Próximo banner">›</button>
        <div class="banner-dots">
          @foreach ($lista as $banner)
            <button type="button" class="{{ $loop->first ? 'is-active' : '' }}" aria-label="Ir para o banner {{ $loop->iteration }}"></button>
          @endforeach
        </div>
      @endif
    </section>
  @endif
@endforeach