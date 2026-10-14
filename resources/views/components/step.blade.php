@props(['prefix', 'num'])
<div {{ $attributes->merge(['class' => 'step']) }}>
  <span class="num">{{ $num }}</span>
  <h3>@content($prefix.'.title')</h3>
  <p>@content($prefix.'.desc')</p>
  @if (\App\Support\SiteContent::has($prefix.'.free'))
    <span class="free">@content($prefix.'.free')</span>
  @endif
</div>
