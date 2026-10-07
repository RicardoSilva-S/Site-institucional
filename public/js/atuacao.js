/**
 * atuacao.js — comportamento da página Atuação
 *   - destaca o atalho da frente que está na tela enquanto a página rola
 *   - no celular, onde os atalhos rolam na horizontal, mantém o ativo visível
 *   - faz a imagem de cada frente surgir suavemente (uma vez) ao entrar na tela
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
        list.scrollTo({ left: active.offsetLeft - 16, behavior: "smooth" });
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

  function setupReveal() {
    const items = document.querySelectorAll(".frente__media");
    if (!items.length || typeof window.IntersectionObserver !== "function") return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add("is-visible");
        observer.unobserve(entry.target);
      });
    }, { rootMargin: "0px 0px -10% 0px" });

    // Só esconde as imagens depois que o observer existe: se algo falhar
    // antes, elas continuam visíveis.
    items.forEach((item) => observer.observe(item));
    document.documentElement.classList.add("js-reveal");
  }

  document.addEventListener("DOMContentLoaded", () => {
    setupFrentesNav();
    setupReveal();
  });
})();
