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

    const isMobile = () => window.innerWidth <= 960;

    function setOpen(isOpen) {
      nav.classList.toggle("is-open", isOpen);
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
      toggle.setAttribute("aria-label", isOpen ? "Fechar menu" : "Abrir menu");
    }

    toggle.addEventListener("click", () => setOpen(!nav.classList.contains("is-open")));

    // Esc fecha o menu mobile e devolve o foco ao botão ☰
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && nav.classList.contains("is-open")) {
        setOpen(false);
        toggle.focus();
      }
    });

    // No mobile, o item "Institucional" abre/fecha o submenu em vez de navegar;
    // os demais links fecham o menu mobile
    nav.querySelectorAll("a").forEach((link) => {
      const isSubToggle = link.matches(".has-sub > a.top-link");
      if (isSubToggle && isMobile()) link.setAttribute("aria-expanded", "false");

      link.addEventListener("click", (e) => {
        if (isSubToggle && isMobile()) {
          e.preventDefault();
          const subOpen = link.parentElement.classList.toggle("is-open");
          link.setAttribute("aria-expanded", subOpen ? "true" : "false");
          return;
        }
        setOpen(false);
      });
    });
  }

  document.addEventListener("DOMContentLoaded", setupMobileMenu);
})();

/**
 * Carrossel de banners do topo (partials/banner.blade.php) e das imagens de
 * seção com mais de um banner (partials/section-banner.blade.php).
 * Troca sozinho a cada 6 s, com setas (só no topo) e bolinhas de navegação.
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
 
    // Quem pediu menos movimento no sistema não recebe a troca automática
    const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    function restart() {
      clearInterval(timer);
      if (reduceMotion) return;
      timer = setInterval(() => show(current + 1), 6000);
    }

    slider.querySelector(".banner-nav--prev")?.addEventListener("click", () => { show(current - 1); restart(); });
    slider.querySelector(".banner-nav--next")?.addEventListener("click", () => { show(current + 1); restart(); });
    dots.forEach((dot, i) => dot.addEventListener("click", () => { show(i); restart(); }));

    // Pausa com o mouse em cima ou com o foco do teclado dentro do carrossel
    slider.addEventListener("mouseenter", () => clearInterval(timer));
    slider.addEventListener("mouseleave", restart);
    slider.addEventListener("focusin", () => clearInterval(timer));
    slider.addEventListener("focusout", (e) => { if (!slider.contains(e.relatedTarget)) restart(); });
 
    restart();
  }
 
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".banner-slider, .section-banner").forEach(setupBannerSlider);
  });
})();

/**
 * Carrossel das etapas da página inicial (.steps-carousel em home.blade.php).
 * As setas avançam/voltam um cartão; cada seta some quando chega na ponta, e
 * as duas somem se todos os cartões couberem na tela.
 */
(function () {
  function setupStepsCarousel(carousel) {
    const track = carousel.querySelector(".steps-track");
    const prev = carousel.querySelector(".steps-nav--prev");
    const next = carousel.querySelector(".steps-nav--next");
    if (!track || !prev || !next) return;
 
    // Largura de um cartão + o espaço entre eles.
    function stepSize() {
      const card = track.querySelector(".step");
      if (!card) return track.clientWidth;
      const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      return card.getBoundingClientRect().width + gap;
    }
 
    function update() {
      const max = track.scrollWidth - track.clientWidth;
      prev.disabled = track.scrollLeft <= 1;
      next.disabled = track.scrollLeft >= max - 1;
      carousel.classList.toggle("is-static", max <= 1);
    }
 
    prev.addEventListener("click", () => track.scrollBy({ left: -stepSize(), behavior: "smooth" }));
    next.addEventListener("click", () => track.scrollBy({ left: stepSize(), behavior: "smooth" }));
    track.addEventListener("scroll", update, { passive: true });
    window.addEventListener("resize", update);
    update();
  }
 
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".steps-carousel").forEach(setupStepsCarousel);
  });
})();

