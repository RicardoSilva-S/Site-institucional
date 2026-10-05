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
  {{-- O formulário grava a mensagem (ContactController@store) e avisa por e-mail.
       Os botões de WhatsApp/e-mail continuam como alternativa (public/js/contato.js). --}}
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
        <form id="form-contato" action="{{ route('contato.enviar') }}" method="POST" novalidate
              data-whatsapp="5544998083001" data-email="faleconosco@idtnpr.org.br">
          @csrf
          @if (session('contact_status'))
            <div id="form-alert" class="form-alert is-visible success" role="alert" aria-live="polite">{{ session('contact_status') }}</div>
          @elseif ($errors->any())
            <div id="form-alert" class="form-alert is-visible error" role="alert" aria-live="polite">Confira os campos destacados e tente de novo.</div>
          @else
            <div id="form-alert" class="form-alert" role="alert" aria-live="polite"></div>
          @endif

          {{-- Campo-isca anti-robô: fica fora da tela e não deve ser preenchido. --}}
          <div aria-hidden="true" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">
            <label for="website">Não preencha este campo</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
          </div>

          <div class="form-grid">
            <div class="field @error('nome') has-error @enderror">
              <label for="nome">Nome <span class="req">*</span></label>
              <input type="text" id="nome" name="nome" value="{{ old('nome') }}" autocomplete="name" required>
              <span class="error-msg">Informe seu nome.</span>
            </div>
            <div class="field">
              <label for="cargo">Cargo ou função</label>
              <input type="text" id="cargo" name="cargo" value="{{ old('cargo') }}">
            </div>
            <div class="field full @error('orgao') has-error @enderror">
              <label for="orgao">Órgão ou município <span class="req">*</span></label>
              <input type="text" id="orgao" name="orgao" value="{{ old('orgao') }}" required>
              <span class="error-msg">Informe o órgão ou município.</span>
            </div>
            <div class="field @error('email') has-error @enderror">
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
                @foreach (\App\Models\ContactMessage::AREAS as $opcao)
                  <option value="{{ $opcao }}" @if (old('area') === $opcao) selected @endif>{{ $opcao }}</option>
                @endforeach
              </select>
            </div>
            <div class="field full @error('mensagem') has-error @enderror">
              <label for="mensagem">Descreva o problema <span class="req">*</span></label>
              <textarea id="mensagem" name="mensagem" required>{{ old('mensagem') }}</textarea>
              <span class="error-msg">Descreva o problema para que possamos ajudar.</span>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enviar mensagem</button>
            <button type="button" class="btn btn-outline" data-send="whatsapp">@content('contato.form.btn_whatsapp')</button>
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
