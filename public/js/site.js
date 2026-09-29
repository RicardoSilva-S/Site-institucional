/**
 * site.js
 * -----------------------------------------------------------------------
 * Roda em todas as páginas públicas do site. Os textos agora são
 * renderizados pelo servidor (Blade + @content(), ver App\Support\SiteContent),
 * então este arquivo só cuida de comportamento no navegador:
 *   - abrir/fechar o menu mobile (☰)
 *   - abrir/fechar o submenu "Institucional" no mobile
 * -----------------------------------------------------------------------
 */

(function () {
  function setupMobileMenu() {
    const toggle = document.querySelector(".menu-toggle");
    const nav = document.querySelector("nav.primary");
    if (!toggle || !nav) return;

    toggle.addEventListener("click", () => {
      const isOpen = nav.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    // Fecha o menu mobile ao clicar num link
    nav.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => nav.classList.remove("is-open"));
    });

    // No mobile, o item "Institucional" abre/fecha o submenu em vez de navegar
    document.querySelectorAll(".has-sub > a.top-link").forEach((link) => {
      link.addEventListener("click", (e) => {
        if (window.innerWidth <= 960) {
          e.preventDefault();
          link.parentElement.classList.toggle("is-open");
        }
      });
    });
  }

  document.addEventListener("DOMContentLoaded", setupMobileMenu);
})();
