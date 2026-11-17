{{-- Ícone do cartão de projeto. Uso: <x-projeto-icone :nome="$projeto->iconeChave()" />
     As chaves são as de App\Models\Projeto::ICONES. Decorativo (aria-hidden):
     o nome do projeto já está escrito ao lado. Traço em currentColor, para
     herdar a cor do .projeto-card__icone (public/css/projetos.css). --}}
@props(['nome' => 'padrao'])

<svg {{ $attributes->merge(['class' => 'projeto-icone']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
  @switch($nome)
    @case('saneamento')
      <path d="M12 3.5c-2.6 3.1-5 6-5 8.7a5 5 0 0 0 10 0c0-2.7-2.4-5.6-5-8.7Z"/>
      <path d="M9.6 13.4c.4 1.2 1.3 1.9 2.4 2"/>
      <path d="M3.5 20c1.4-.9 2.8-.9 4.2 0s2.9.9 4.3 0 2.9-.9 4.3 0 2.8.9 4.2 0"/>
      @break
    @case('autoatendimento')
      <rect x="6" y="2.8" width="12" height="13" rx="1.6"/>
      <path d="M9 6.5h6M9 9.5h6M9 12.5h3"/>
      <path d="M10 15.8v3.4M14 15.8v3.4M7.5 21.2h9"/>
      @break
    @case('fiscal')
      <path d="M14 3H7a1.8 1.8 0 0 0-1.8 1.8v14.4A1.8 1.8 0 0 0 7 21h5"/>
      <path d="M14 3l4.8 4.8V12"/>
      <path d="M14 3v4.8h4.8M8.6 11.5h6M8.6 15h3"/>
      <path d="m15 18.6 1.8 1.8 3.4-3.6"/>
      @break
    @case('legislativo')
      <circle cx="12" cy="12" r="1.8"/>
      <path d="M8.5 15.5a5 5 0 0 1 0-7M15.5 8.5a5 5 0 0 1 0 7"/>
      <path d="M5.6 18.4a9 9 0 0 1 0-12.8M18.4 5.6a9 9 0 0 1 0 12.8"/>
      @break
    @case('juridico')
      <path d="M12 3.5v17M8 20.5h8M5 7h14"/>
      <path d="M12 5.2V7"/>
      <path d="m5 7-2.5 6a2.8 2.8 0 0 0 5 0L5 7ZM19 7l-2.5 6a2.8 2.8 0 0 0 5 0L19 7Z"/>
      @break
    @case('formacao')
      <path d="M2.5 9.5 12 5l9.5 4.5L12 14 2.5 9.5Z"/>
      <path d="M6.5 11.5v4.2c1.5 1.4 3.4 2.1 5.5 2.1s4-.7 5.5-2.1v-4.2"/>
      <path d="M21.5 9.5v5"/>
      @break
    @default
      <rect x="3.5" y="3.5" width="7" height="7" rx="1.4"/>
      <rect x="13.5" y="3.5" width="7" height="7" rx="1.4"/>
      <rect x="3.5" y="13.5" width="7" height="7" rx="1.4"/>
      <path d="M17 13.5v7M13.5 17h7"/>
  @endswitch
</svg>
