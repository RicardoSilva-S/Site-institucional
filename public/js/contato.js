/**
 * contato.js
 * -----------------------------------------------------------------------
 * Só roda na página de Contato. O formulário não grava no servidor ainda
 * (ver comentário em resources/views/site/contato.blade.php): este script
 * valida os campos obrigatórios antes do envio normal (que grava no servidor,
 * ver ContactController) e, ao clicar em "Enviar pelo WhatsApp" ou
 * "Enviar por e-mail", monta a mensagem e abre o WhatsApp/e-mail do
 * navegador — quem envia é o próprio visitante, nada fica salvo por esses dois.
 * -----------------------------------------------------------------------
 */

(function () {
  function validate(form) {
    let ok = true;

    form.querySelectorAll("[required]").forEach((field) => {
      const wrapper = field.closest(".field");
      const valid = field.value.trim() !== "";
      if (wrapper) wrapper.classList.toggle("has-error", !valid);
      if (!valid) ok = false;
    });

    return ok;
  }

  function buildMessage(form) {
    const get = (name) => (form.elements[name] ? form.elements[name].value.trim() : "");

    const linhas = [
      "Solicitação de diagnóstico — site IDTNPR",
      `Nome: ${get("nome")}`,
    ];
    if (get("cargo")) linhas.push(`Cargo/função: ${get("cargo")}`);
    linhas.push(`Órgão/município: ${get("orgao")}`);
    if (get("email")) linhas.push(`E-mail: ${get("email")}`);
    if (get("telefone")) linhas.push(`Telefone: ${get("telefone")}`);
    if (get("area")) linhas.push(`Área do problema: ${get("area")}`);
    linhas.push("", `Descrição: ${get("mensagem")}`);

    return linhas.join("\n");
  }

  function showAlert(box, message, type) {
    if (!box) return;
    box.textContent = message;
    box.className = `form-alert is-visible ${type}`;
  }

  function setupForm() {
    const form = document.getElementById("form-contato");
    if (!form) return;

    const alertBox = document.getElementById("form-alert");

    form.addEventListener("submit", (event) => {
      if (!validate(form)) {
        event.preventDefault();
        showAlert(alertBox, "Preencha os campos obrigatórios antes de enviar.", "error");
      }
    });

    form.querySelectorAll("[data-send]").forEach((button) => {
      button.addEventListener("click", () => {
        if (!validate(form)) {
          showAlert(alertBox, "Preencha os campos obrigatórios antes de enviar.", "error");
          return;
        }

        const mensagem = buildMessage(form);

        if (button.dataset.send === "whatsapp") {
          const numero = form.dataset.whatsapp;
          window.open(`https://wa.me/${numero}?text=${encodeURIComponent(mensagem)}`, "_blank", "noopener");
        } else if (button.dataset.send === "email") {
          const destino = form.dataset.email;
          const assunto = encodeURIComponent("Solicitação de diagnóstico — site IDTNPR");
          window.location.href = `mailto:${destino}?subject=${assunto}&body=${encodeURIComponent(mensagem)}`;
        }

        showAlert(alertBox, "Mensagem pronta. Confira e envie na janela que abriu.", "success");
      });
    });
  }

  document.addEventListener("DOMContentLoaded", setupForm);
})();
