@extends('layouts.app')

@section('title', 'Política de Privacidade | IDTNPR')
@section('description', 'Como o IDTNPR coleta, usa e protege os dados pessoais de quem utiliza este site, conforme a LGPD (Lei nº 13.709/2018).')

@push('styles')
<style>
  .policy-list { margin: 12px 0 0 20px; }
  .policy-list li { margin-bottom: 8px; color: var(--ink-soft); }
  .policy-updated { margin-top: 14px; font-size: 14px; opacity: .8; }
</style>
@endpush

@section('content')

  <!-- TOPO -->
  <section class="page-hero">
    <div class="wrap">
      <span class="eyebrow"><span class="dot"></span> LGPD</span>
      <h1>Política de Privacidade</h1>
      <p class="lead">Como o IDTNPR trata os dados pessoais de quem utiliza este site, conforme a Lei nº 13.709/2018 (Lei Geral de Proteção de Dados).</p>
      <p class="policy-updated">Última atualização: [PREENCHER DATA]</p>
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
        <p>O Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense (IDTNPR), CNPJ [PREENCHER], com sede em Sarandi/PR, é o responsável pelo tratamento dos dados pessoais coletados por este site.</p>
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
        <h2>Por quanto tempo guardamos</h2>
      </div>
      <div class="info-box">
        <p>[PREENCHER: prazo de guarda dos dados e como são protegidos]</p>
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

  <!-- ENCARREGADO -->
  <section class="alt">
    <div class="wrap">
      <div class="section-head">
        <span class="kicker">Contato</span>
        <h2>Encarregado de dados (DPO)</h2>
        <p class="sub">Para exercer seus direitos ou tirar dúvidas sobre esta política, fale com o nosso encarregado.</p>
      </div>
      <div class="info-box">
        <p><strong>Nome:</strong> [PREENCHER]</p>
        <p><strong>E-mail:</strong> [PREENCHER]</p>
      </div>
    </div>
  </section>

@endsection 