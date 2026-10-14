@extends('layouts.app')

@section('title', 'Página não encontrada | IDTNPR')
@section('description', 'A página que você procura não existe ou mudou de endereço. Use os atalhos para voltar ao site do IDTNPR.')
@section('robots', 'noindex, follow')

@section('content')
  <section class="page-hero">
    <div class="wrap">
      <span class="eyebrow"><span class="dot" aria-hidden="true"></span> Erro 404</span>
      <h1>Página não encontrada</h1>
      <p class="lead">O endereço que você acessou não existe ou mudou de lugar. Confira se digitou corretamente ou use os atalhos abaixo para continuar navegando.</p>
      <div class="cta-row">
        <a href="{{ route('home') }}" class="btn btn-primary">Voltar para o início</a>
        <a href="{{ route('contato') }}" class="btn btn-outline">Falar com o Instituto</a>
      </div>
    </div>
  </section>

  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Atalhos</span>
        <h2>Talvez você procure por</h2>
      </div>

      <div class="cards-grid">
        <div class="card">
          <span class="kicker">Institucional</span>
          <h3><a href="{{ route('institucional') }}">Quem somos</a></h3>
          <p>Conheça o Instituto, a governança e a linha do tempo.</p>
        </div>
        <div class="card">
          <span class="kicker">Atuação</span>
          <h3><a href="{{ route('atuacao') }}">Frentes de atuação</a></h3>
          <p>Como o Instituto apoia a gestão pública com tecnologia.</p>
        </div>
        <div class="card">
          <span class="kicker">Projetos</span>
          <h3><a href="{{ route('projetos') }}">Projetos e soluções</a></h3>
          <p>Iniciativas tecnológicas para prefeituras e câmaras.</p>
        </div>
        <div class="card">
          <span class="kicker">Editais</span>
          <h3><a href="{{ route('editais') }}">Editais e chamamentos</a></h3>
          <p>Chamamentos públicos abertos e encerrados.</p>
        </div>
        <div class="card">
          <span class="kicker">Transparência</span>
          <h3><a href="{{ route('transparencia') }}">Portal da Transparência</a></h3>
          <p>Documentos e prestação de contas do Instituto.</p>
        </div>
        <div class="card">
          <span class="kicker">Contato</span>
          <h3><a href="{{ route('contato') }}">Fale conosco</a></h3>
          <p>Tire dúvidas e peça um diagnóstico gratuito.</p>
        </div>
      </div>
    </div>
  </section>
@endsection
