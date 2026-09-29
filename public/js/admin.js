/**
 * admin.js
 * -----------------------------------------------------------------------
 * O formulário do painel (/admin/conteudo) agora é renderizado e salvo
 * pelo servidor (Blade + Admin\ContentController), então este arquivo só
 * cuida de duas coisas no navegador:
 *   - filtrar os campos por texto digitado na busca
 *   - confirmar antes de restaurar os textos padrão (ação destrutiva)
 * -----------------------------------------------------------------------
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
        const match = !term || label.includes(term) || value.includes(term);
        row.style.display = match ? "" : "none";
      });

      if (term) {
        form.querySelectorAll("details.admin-page").forEach((d) => (d.open = true));
      }
    });
  }

  function setupResetConfirm() {
    const resetForm = document.getElementById("admin-reset-form");
    if (!resetForm) return;

    resetForm.addEventListener("submit", (e) => {
      const confirmed = confirm(
        "Restaurar todos os textos para o padrão original? Isso apaga todas as edições salvas."
      );
      if (!confirmed) e.preventDefault();
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    setupSearch();
    setupResetConfirm();
  });
})();
