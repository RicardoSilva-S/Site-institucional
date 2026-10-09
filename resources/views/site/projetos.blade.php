@extends('layouts.app')

@section('title', 'Projetos e Soluções | IDTNPR')
@section('description', 'Conheça as iniciativas tecnológicas desenvolvidas pelo IDTNPR para modernizar a administração pública, prefeituras e câmaras.')

{{-- Página Projetos: hero simples (.page-hero), grade de cartões em duas
     colunas (.norma-grid + .card) com selo de situação (.status) e chamada
     final (.final-cta). Usa apenas classes já existentes no style.css. --}}
@section('content')
  <section class="page-hero">
    <div class="wrap">
      <span class="eyebrow"><span class="dot"></span> Inovação na prática</span>
      <h1>Projetos e Soluções</h1>
      <p class="lead">Conheça as iniciativas tecnológicas desenvolvidas pelo Instituto para modernizar a administração pública, prefeituras e câmaras.</p>
    </div>
  </section>

  <section id="projetos">
    <div class="wrap">
      <div class="norma-grid">

        <article class="card">
          <span class="kicker"><span class="status publicado">Implementado</span></span>
          <h3>Totem de Autoatendimento</h3>
          <p>Focado em agilizar o atendimento ao cidadão.</p>
        </article>

        <article class="card">
          <span class="kicker"><span class="status">Em expansão</span></span>
          <h3>Alô Câmara</h3>
          <p>Solução para o legislativo aproximar a população dos vereadores.</p>
        </article>

        <article class="card">
          <span class="kicker"><span class="status">Consultoria</span></span>
          <h3>Lei Municipal de Inovação</h3>
          <p>Estruturação do marco legal para municípios.</p>
        </article>

        <article class="card">
          <span class="kicker"><span class="status elaboracao">Fase Piloto</span></span>
          <h3>Gestão de Manutenção Municipal</h3>
          <p>Sistema para controle de frotas e obras.</p>
        </article>

      </div>
    </div>
  </section>

  <section class="final-cta">
    <div class="wrap">
      <div>
        <h2>Quer levar um destes projetos para o seu município?</h2>
      </div>
      <a href="{{ route('contato') }}" class="btn btn-gold">Solicitar diagnóstico gratuito</a>
    </div>
  </section>
@endsection