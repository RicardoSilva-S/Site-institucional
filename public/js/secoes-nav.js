/**
 * secoes-nav.js — barra de atalhos para as seções (.frentes-nav), usada nas
 * páginas Atuação e Institucional
 *   - destaca o atalho da seção que está na tela enquanto a página rola
 *   - no celular, onde os atalhos rolam na horizontal, mantém o ativo visível
 */
(function () {
  function setupFrentesNav() {
    const nav = document.querySelector(".frentes-nav");
    if (!nav) return;

    const list = nav.querySelector("ul");
    const links = Array.from(nav.querySelectorAll('a[href^="#"]'));
    const sections = links.map((link) => document.querySelector(link.getAttribute("href")));
    let current = -2;
    let ticking = false;

    function update() {
      ticking = false;

      // A frente "atual" é a última cujo topo já passou um pouco da barra de
      // atalhos. Antes da barra grudar no topo (ainda no início), nenhuma.
      const box = nav.getBoundingClientRect();
      const stuck = box.top <= parseFloat(getComputedStyle(nav).top) + 1;
      let index = -1;
      if (stuck) {
        sections.forEach((section, i) => {
          if (section && section.getBoundingClientRect().top <= box.bottom + 120) index = i;
        });
      }

      if (index === current) return;
      current = index;

      links.forEach((link, i) => {
        link.classList.toggle("is-active", i === index);
        if (i === index) link.setAttribute("aria-current", "true");
        else link.removeAttribute("aria-current");
      });

      const active = links[index];
      if (active && list.scrollWidth > list.clientWidth) {
        list.scrollTo({ left: active.offsetLeft, behavior: "smooth" });
      }
    }

    window.addEventListener("scroll", () => {
      if (!ticking) {
        ticking = true;
        window.requestAnimationFrame(update);
      }
    }, { passive: true });

    update();
  }

  document.addEventListener("DOMContentLoaded", setupFrentesNav);
})();
