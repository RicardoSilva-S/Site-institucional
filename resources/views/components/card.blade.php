@props(['prefix'])
<div {{ $attributes->merge(['class' => 'card']) }}>
  <span class="kicker">@content($prefix.'.kicker')</span>
  <h3>@content($prefix.'.title')</h3>
  <p>@content($prefix.'.desc')</p>
</div>
