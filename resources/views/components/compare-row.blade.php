@props(['prefix'])
<div class="compare-row">
  <div class="compare-cell bad"><span class="icon" aria-hidden="true">✕</span><span>@content($prefix.'.bad')</span></div>
  <div class="compare-cell good"><span class="icon" aria-hidden="true">✓</span><span>@content($prefix.'.good')</span></div>
</div>
