/**
 * admin.js — comportamento do painel /adm (no navegador)
 *   - busca de textos na página aberta
 *   - confirmação antes de excluir (botões com data-confirm)
 *   - menu lateral recolhível no celular
 *   - pré-visualização da imagem no formulário de banner
 */
(function () {
  function setupSearch() {
    const input = document.getElementById("admin-search");
    const form = document.getElementById("admin-form");
    if (!input || !form) return;

    input.addEventListener("input", (e) => {
      const term = e.target.value.trim().toLowerCase();

      form.querySelectorAll(".admin-field").forEach((row) => {
        const label = row.querySelector("label").textContent.toLowerCase();
        const value = row.querySelector("[name]").value.toLowerCase();
        row.style.display = !term || label.includes(term) || value.includes(term) ? "" : "none";
      });

      form.querySelectorAll(".admin-group").forEach((group) => {
        const visible = group.querySelectorAll('.admin-field:not([style*="none"])').length;
        group.style.display = term && !visible ? "none" : "";
      });
    });
  }

  function setupConfirm() {
    document.addEventListener("click", (e) => {
      const button = e.target.closest("[data-confirm]");
      if (button && !confirm(button.dataset.confirm)) e.preventDefault();
    });
  }

  function setupSidebarToggle() {
    const toggle = document.querySelector(".admin-sidebar__toggle");
    const sidebar = document.querySelector(".admin-sidebar");
    if (!toggle || !sidebar) return;

    toggle.addEventListener("click", () => {
      const open = sidebar.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
  }

  function setupImagePreview() {
    const input = document.getElementById("image");
    const preview = document.getElementById("image-preview");
    if (!input || !preview) return;

    input.addEventListener("change", () => {
      const file = input.files && input.files[0];
      if (!file) return;
      preview.src = URL.createObjectURL(file);
      preview.hidden = false;
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    setupSearch();
    setupConfirm();
    setupSidebarToggle();
    setupImagePreview();
  });
})();