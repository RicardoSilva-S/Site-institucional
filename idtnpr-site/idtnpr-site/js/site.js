/**
 * site.js
 * -----------------------------------------------------------------------
 * Roda em TODAS as páginas públicas do site (index.html e as próximas
 * páginas que forem criadas). Faz duas coisas:
 *
 *   1. Aplica, sobre os elementos com [data-edit-id], qualquer texto que
 *      tenha sido salvo no painel /admin.html (guardado no localStorage
 *      do navegador). Se nada foi editado, o texto original do HTML é
 *      mantido — ou seja, o site funciona normalmente mesmo sem o painel.
 *
 *   2. Liga o menu mobile (☰) e o menu suspenso "Institucional".
 *
 * Depende de content.js estar carregado ANTES deste arquivo.
 * -----------------------------------------------------------------------
 */

(function () {
  function applySavedContent() {
    let overrides = {};
    try {
      overrides = JSON.parse(localStorage.getItem(CONTENT_STORAGE_KEY)) || {};
    } catch (e) {
      overrides = {};
    }

    document.querySelectorAll("[data-edit-id]").forEach((el) => {
      const key = el.getAttribute("data-edit-id");
      if (Object.prototype.hasOwnProperty.call(overrides, key) && overrides[key] !== "") {
        el.textContent = overrides[key];
      }
    });
  }

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

  document.addEventListener("DOMContentLoaded", () => {
    applySavedContent();
    setupMobileMenu();
  });
})();
