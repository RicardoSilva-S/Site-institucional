@extends('layouts.app')

@section('title', 'Política de Privacidade | IDTNPR')
@section('description', 'Como o IDTNPR coleta, usa e protege os dados pessoais de quem utiliza este site, conforme a LGPD (Lei nº 13.709/2018).')

@push('styles')
<style>
  .policy-list { margin: 12px 0 0 20px; }
  .policy-list li { margin-bottom: 8px; color: var(--ink-soft); }
  .policy-updated { margin-top: 14px; font-size: 14px; opacity: .8; }

  .policy-feature { display: flex; gap: 16px; align-items: flex-start; }
  .policy-feature + .policy-feature { margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--line); }
  .policy-icon {
    flex-shrink: 0; width: 52px; height: 52px; border-radius: 50%;
    background: var(--gold-soft); color: var(--navy);
    display: flex; align-items: center; justify-content: center;
  }
  .policy-icon svg { width: 26px; height: 26px; }
  .policy-feature h3 { font-size: 19.5px; line-height: 1.3; margin-bottom: 6px; color: var(--ink); }
  .section-head .kicker { font-size:19px; letter-spacing: .04em; }
  .policy-hero { display: flex; align-items: center; gap: 44px; }
  .policy-hero-icon { margin-left: -218px; }
  .policy-hero-icon { flex-shrink: 0; width: 190px; height: 190px; border-radius: 22px; }
  .policy-hero-icon svg { display: block; width: 100%; height: auto; }
  @media (max-width: 760px) {
  .policy-hero { flex-direction: column; align-items: flex-start; gap: 20px; }
  .policy-hero-icon { width: 110px; }
  }
</style>
@endpush

@section('content')

  <!-- TOPO -->
   <section class="page-hero">
    <div class="wrap policy-hero">
      <div class="policy-hero-icon" aria-hidden="true">
        <svg viewBox="0 0 200 228" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="100" cy="218" rx="52" ry="6" fill="#0F2A5C" opacity=".12"/>
          <path d="M100 8 L182 37 V100 C182 152 147 190 100 210 C53 190 18 152 18 100 V37 Z" fill="#F2E6CE"/>
          <path d="M100 23 L169 47 V100 C169 143 140 176 100 194 C60 176 31 143 31 100 V47 Z" fill="#1F4C91"/>
          <path d="M100 23 L169 47 V100 C169 143 140 176 100 194 Z" fill="#0F2A5C"/>
          <path d="M80 100 V82 a20 20 0 0 1 40 0 V100" fill="none" stroke="#fff" stroke-width="11" stroke-linecap="round"/>
          <rect x="66" y="96" width="68" height="54" rx="9" fill="#fff"/>
          <circle cx="100" cy="117" r="8" fill="#0F2A5C"/>
          <rect x="96" y="119" width="8" height="17" rx="3" fill="#0F2A5C"/>
        </svg>
      </div>
      <div>
        <span class="eyebrow"><span class="dot"></span> LGPD</span>
        <h1>Política de Privacidade</h1>
        <p class="lead">Como o IDTNPR trata os dados pessoais de quem utiliza este site, conforme a Lei nº 13.709/2018 (Lei Geral de Proteção de Dados).</p>
        <p class="policy-updated">Última atualização: outubro de 2026</p>
      </div>
    </div>
  </section>

  <!-- CONTROLADOR E DADOS -->
  <section>
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Quem somos</span>
        <h2>Controlador dos dados</h2>
      </div>
      <div class="info-box">
        <p>O Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense (IDTNPR), CNPJ 64.039.593/0001-82, com sede em Sarandi/PR, é o responsável pelo tratamento dos dados pessoais coletados por este site.</p>
      </div>

      <div class="section-head" style="margin-top:48px;">
        <span class="kicker">Coleta</span>
        <h2>Quais dados coletamos</h2>
      </div>
      <div class="info-box">
        <p>Coletamos apenas os dados que você nos envia voluntariamente pelo formulário de contato:</p>
        <ul class="policy-list">
          <li>Nome</li>
          <li>E-mail</li>
          <li>Telefone (quando informado)</li>
          <li>O conteúdo da mensagem enviada</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- FINALIDADE E COOKIES -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Uso</span>
        <h2>Para que usamos os seus dados</h2>
      </div>
      <div class="info-box">
        <p>Os dados são usados exclusivamente para responder à sua solicitação e manter o contato sobre o assunto tratado. Não vendemos nem compartilhamos seus dados para fins comerciais.</p>
      </div>

      <div class="section-head" style="margin-top:48px;">
        <span class="kicker">Cookies</span>
        <h2>Uso de cookies</h2>
      </div>
      <div class="info-box">
        <p>Este site utiliza apenas cookies necessários ao seu funcionamento, como o cookie de sessão. Não utilizamos cookies de publicidade ou de rastreamento.</p>
      </div>
    </div>
  </section>

  <!-- ARMAZENAMENTO E DIREITOS -->
  <section>
    <div class="wrap">
            <div class="section-head">
        <span class="kicker">Armazenamento</span>
        <h2>Como guardamos seus dados</h2>
      </div>
      <div class="info-box">
        <p>Os dados enviados pelo formulário de contato ficam armazenados de forma segura em nossos sistemas, com acesso restrito às pessoas responsáveis por responder às solicitações.</p>
        <p style="margin-top:14px;">Você pode solicitar a exclusão dos seus dados a qualquer momento, pelos canais de contato indicados ao final desta página.</p>
      </div>

      <div class="section-head" style="margin-top:48px;">
        <span class="kicker">Seus direitos</span>
        <h2>O que você pode solicitar</h2>
      </div>
      <div class="info-box">
        <p>Nos termos do art. 18 da LGPD, você pode, a qualquer momento:</p>
        <ul class="policy-list">
          <li>Confirmar se tratamos seus dados e acessá-los</li>
          <li>Corrigir dados incompletos ou desatualizados</li>
          <li>Pedir a anonimização, o bloqueio ou a exclusão dos dados</li>
          <li>Saber com quem seus dados foram compartilhados</li>
          <li>Revogar o consentimento</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- CONTATO -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Fale conosco</span>
        <h2>Dúvidas ou solicitações sobre seus dados</h2>
        <p class="sub">Para exercer seus direitos ou tirar dúvidas sobre esta política, entre em contato pelos nossos canais oficiais.</p>
      </div>
      <div class="info-box">
        <div class="policy-feature">
          <span class="policy-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="5" width="18" height="14" rx="2"/>
              <path d="M3 7l9 6 9-6"/>
            </svg>
          </span>
          <div>
            <h3>E-mail</h3>
            <p><a href="mailto:faleconosco@idtnpr.org.br">faleconosco@idtnpr.org.br</a></p>
          </div>
        </div>

        <div class="policy-feature">
          <span class="policy-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12a9 9 0 0 1-13.5 7.8L3 21l1.2-4.5A9 9 0 1 1 21 12z"/>
            </svg>
          </span>
          <div>
            <h3>WhatsApp</h3>
            <p><a href="https://wa.me/5544998083001" target="_blank" rel="noopener">(44) 99808-3001</a></p>
          </div>
        </div>
      </div>

      <p style="margin-top:24px;">
        <a href="{{ url('/contato') }}" class="btn btn-primary">Ir para a página de Contato</a>
      </p>
    </div>
  </section>
@endsection 