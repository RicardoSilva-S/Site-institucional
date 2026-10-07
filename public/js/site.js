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

/**
 * Carrossel de banners do topo (partials/banner.blade.php).
 * Troca sozinho a cada 6 s, com setas e bolinhas de navegação.
 */
(function () {
  function setupBannerSlider(slider) {
    const slides = slider.querySelectorAll(".banner-slide");
    const dots = slider.querySelectorAll(".banner-dots button");
    if (slides.length < 2) return;
 
    let current = 0;
    let timer = null;
 
    function show(index) {
      current = (index + slides.length) % slides.length;
      slides.forEach((slide, i) => {
        slide.classList.toggle("is-active", i === current);
        slide.setAttribute("aria-hidden", i === current ? "false" : "true");
      });
      dots.forEach((dot, i) => dot.classList.toggle("is-active", i === current));
    }
 
    function restart() {
      clearInterval(timer);
      timer = setInterval(() => show(current + 1), 6000);
    }
 
    slider.querySelector(".banner-nav--prev")?.addEventListener("click", () => { show(current - 1); restart(); });
    slider.querySelector(".banner-nav--next")?.addEventListener("click", () => { show(current + 1); restart(); });
    dots.forEach((dot, i) => dot.addEventListener("click", () => { show(i); restart(); }));
 
    slider.addEventListener("mouseenter", () => clearInterval(timer));
    slider.addEventListener("mouseleave", restart);
 
    restart();
  }
 
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".banner-slider").forEach(setupBannerSlider);
  });
})();
