{{-- Imagem ao lado de uma seção. Mostra os banners ativos cadastrados para
     esta posição (em carrossel, se houver mais de um) ou, sem nenhum, a imagem
     padrão do config/site_content.php. Uso:
       @include('partials.section-banner', ['slot' => 'governanca'])
     Dados vêm do View Composer em App\Providers\AppServiceProvider. --}}
@if ($slotBanners->isNotEmpty() || $fallback)
  <div class="section-banner"@if ($slotBanners->count() > 1) aria-roledescription="carrossel" aria-label="Imagens da seção"@endif>
    @forelse ($slotBanners as $banner)
      <figure class="banner-slide{{ $loop->first ? ' is-active' : '' }}" aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
        <img src="{{ $banner->imageUrl() }}" alt="{{ $banner->title }}" @unless($loop->first && ($eager ?? false)) loading="lazy" @endunless>
        @if ($banner->title || $banner->subtitle)
          <figcaption class="section-banner__caption">
            @if ($banner->title)<strong>{{ $banner->title }}</strong>@endif
            @if ($banner->subtitle)<span>{{ $banner->subtitle }}</span>@endif
          </figcaption>
        @endif
        @if ($banner->link)
          <a href="{{ $banner->link }}" class="banner-slide__link" aria-label="{{ $banner->title ?: 'Abrir banner' }}"></a>
        @endif
      </figure>
    @empty
      <figure class="banner-slide is-active">
        <img src="{{ asset($fallback) }}" alt="" @unless($eager ?? false) loading="lazy" @endunless>
      </figure>
    @endforelse

    @if ($slotBanners->count() > 1)
      <div class="banner-dots">
        @foreach ($slotBanners as $banner)
          <button type="button" class="{{ $loop->first ? 'is-active' : '' }}" aria-label="Ir para a imagem {{ $loop->iteration }}"></button>
        @endforeach
      </div>
    @endif
  </div>
@endif
