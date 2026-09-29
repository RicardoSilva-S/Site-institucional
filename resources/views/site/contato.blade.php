@extends('layouts.app')

@section('title', 'Contato e Ouvidoria | IDTNPR')
@section('description', 'Fale com o IDTNPR: contato institucional, solicitação de diagnóstico gratuito, material para procuradorias municipais e canal de ouvidoria.')

@section('content')

  <!-- HERO -->
  <section class="page-hero">
    <div class="wrap">
      <h1>@content('contato.hero.title')</h1>
      <p class="lead">@content('contato.hero.lead')</p>
    </div>
  </section>

  <!-- CONTATO INSTITUCIONAL -->
  {{-- E-mail, WhatsApp, Instagram, endereços e CNPJ são dados de cadastro, não
       "texto" do site — ficam fixos aqui, como o número de WhatsApp já fica
       fixo em marco-legal.blade.php, em vez de editáveis pelo painel. --}}
  <section style="padding-top:36px;">
    <div class="wrap contact-grid">
      <div class="contact-card">
        <h3>@content('contato.institucional.card1.title')</h3>
        <dl>
          <dt>E-mail</dt>
          <dd><a href="mailto:faleconosco@idtnpr.org.br">faleconosco@idtnpr.org.br</a></dd>
          <dt>WhatsApp</dt>
          <dd><a href="https://wa.me/5544998083001" target="_blank" rel="noopener">(44) 99808-3001</a></dd>
          <dt>Instagram</dt>
          <dd><a href="https://www.instagram.com/instituto_idtnpr" target="_blank" rel="noopener">@instituto_idtnpr</a></dd>
        </dl>
      </div>
      <div class="contact-card">
        <h3>@content('contato.institucional.card2.title')</h3>
        <dl>
          <dt>Sede</dt>
          <dd>Rua João Marangoni, nº 2908, Casa 7<br>Bairro Panorama · CEP 87.113-310<br>Sarandi – Paraná</dd>
          <dt>Correspondência</dt>
          <dd>Avenida Riachuelo, nº 870, Sala 03<br>CEP 87.114-240 · Sarandi – Paraná</dd>
        </dl>
      </div>
      <div class="contact-card">
        <h3>@content('contato.institucional.card3.title')</h3>
        <dl>
          <dt>Razão social</dt>
          <dd>@content('contato.institucional.razao_social')</dd>
          <dt>CNPJ</dt>
          <dd>64.039.593/0001-82</dd>
          <dt>Natureza jurídica</dt>
          <dd>@content('contato.institucional.natureza')</dd>
        </dl>
      </div>
    </div>
  </section>

  <!-- FORMULÁRIO DE DIAGNÓSTICO -->
  {{--
    O formulário ainda não grava no servidor (action="#"). Para integrar,
    crie um controller/rota (ex.: rota "contato.enviar"), troque o action
    para route('contato.enviar') e mantenha o @csrf. Por enquanto, o JS
    (public/js/contato.js) monta a mensagem e abre WhatsApp/e-mail direto,
    como no site estático original.
  --}}
  <section class="alt" id="diagnostico">
    <div class="wrap form-layout">
      <div class="form-intro">
        <div class="section-head" style="margin-bottom:0;">
          <span class="kicker">@content('contato.diagnostico.kicker')</span>
          <h2>@content('contato.diagnostico.title')</h2>
        </div>
        <p>@content('contato.diagnostico.text1')</p>
        <p>@content('contato.diagnostico.text2')</p>

        <div class="contact-audience">
          <div class="contact-card">
            <h3>@content('contato.diagnostico.aud1.title')</h3>
            <p>@content('contato.diagnostico.aud1.text')</p>
          </div>
          <div class="contact-card">
            <h3>@content('contato.diagnostico.aud2.title')</h3>
            <p>@content('contato.diagnostico.aud2.text') <a href="{{ route('marco-legal') }}">@content('contato.diagnostico.aud2.link')</a>.</p>
          </div>
          <div class="contact-card">
            <h3>@content('contato.diagnostico.aud3.title')</h3>
            <p>@content('contato.diagnostico.aud3.text')</p>
          </div>
        </div>
      </div>

      <div class="form-card">
        <form id="form-contato" action="#" method="POST" novalidate
              data-whatsapp="5544998083001" data-email="faleconosco@idtnpr.org.br">
          @csrf
          <div id="form-alert" class="form-alert" role="alert" aria-live="polite"></div>

          <div class="form-grid">
            <div class="field">
              <label for="nome">Nome <span class="req">*</span></label>
              <input type="text" id="nome" name="nome" value="{{ old('nome') }}" autocomplete="name" required>
              <span class="error-msg">Informe seu nome.</span>
            </div>
            <div class="field">
              <label for="cargo">Cargo ou função</label>
              <input type="text" id="cargo" name="cargo" value="{{ old('cargo') }}">
            </div>
            <div class="field full">
              <label for="orgao">Órgão ou município <span class="req">*</span></label>
              <input type="text" id="orgao" name="orgao" value="{{ old('orgao') }}" required>
              <span class="error-msg">Informe o órgão ou município.</span>
            </div>
            <div class="field">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email">
              <span class="error-msg">Informe um e-mail válido.</span>
            </div>
            <div class="field">
              <label for="telefone">Telefone ou WhatsApp</label>
              <input type="tel" id="telefone" name="telefone" value="{{ old('telefone') }}" autocomplete="tel">
            </div>
            <div class="field full">
              <label for="area">Área do problema</label>
              <select id="area" name="area">
                <option value="">Selecione</option>
                @foreach ([
                  'Atendimento ao cidadão', 'Tributos e arrecadação', 'Contabilidade e prestação de contas',
                  'Manutenção e serviços públicos', 'Câmara Municipal', 'Lei de inovação e política de CT&I',
                  'Capacitação de servidores', 'Outro',
                ] as $opcao)
                  <option value="{{ $opcao }}" @selected(old('area') === $opcao)>{{ $opcao }}</option>
                @endforeach
              </select>
            </div>
            <div class="field full">
              <label for="mensagem">Descreva o problema <span class="req">*</span></label>
              <textarea id="mensagem" name="mensagem" required>{{ old('mensagem') }}</textarea>
              <span class="error-msg">Descreva o problema para que possamos ajudar.</span>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn btn-primary" data-send="whatsapp">@content('contato.form.btn_whatsapp')</button>
            <button type="button" class="btn btn-outline" data-send="email">@content('contato.form.btn_email')</button>
          </div>
          <p class="form-note">@content('contato.form.note') Ver a <a href="#">Política de Privacidade</a>.</p>
        </form>
      </div>
    </div>
  </section>

  <!-- OUVIDORIA -->
  <section id="ouvidoria" style="scroll-margin-top:90px;">
    <div class="wrap ouvidoria">
      <div>
        <div class="section-head" style="margin-bottom:0;">
          <span class="kicker">@content('contato.ouvidoria.kicker')</span>
          <h2>@content('contato.ouvidoria.title')</h2>
        </div>
        <p>@content('contato.ouvidoria.text1')</p>
        <p>@content('contato.ouvidoria.text2')</p>
      </div>
      <div class="ouvidoria-box">
        <span class="tag">@content('contato.ouvidoria.tag')</span>
        <a class="mail" href="mailto:ouvidoria@idtnpr.org.br">ouvidoria@idtnpr.org.br</a>
        <p>@content('contato.ouvidoria.note')</p>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
  <script src="{{ asset('js/contato.js') }}"></script>
@endpush
