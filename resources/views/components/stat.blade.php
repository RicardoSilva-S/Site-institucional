@props(['prefix'])
<div {{ $attributes->merge(['class' => 'stat']) }}>
  <div class="num">@content($prefix.'.num')</div>
  <div class="label">@content($prefix.'.label')</div>
</div>
