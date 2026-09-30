/**
 * transparencia.js
 * -----------------------------------------------------------------------
 * Só roda no Portal da Transparência. Cuida da busca por nome de
 * documento e dos filtros por seção (chips), tudo no navegador — a lista
 * de documentos em si vem pronta do servidor (ver
 * resources/views/site/transparencia.blade.php).
 * -----------------------------------------------------------------------
 */

(function () {
  function setupFilters() {
    const search = document.getElementById("doc-busca");
    const chips = document.querySelectorAll(".chip[data-filter]");
    const sections = document.querySelectorAll(".doc-section");
    const empty = document.getElementById("doc-vazio");
    if (!search || !sections.length) return;

    let activeFilter = "todos";

    function apply() {
      const term = search.value.trim().toLowerCase();
      let anyVisible = false;

      sections.forEach((section) => {
        const matchesFilter = activeFilter === "todos" || section.dataset.section === activeFilter;
        let sectionHasMatch = false;

        section.querySelectorAll(".doc-item").forEach((item) => {
          const matchesTerm = !term || item.dataset.name.includes(term);
          const visible = matchesFilter && matchesTerm;
          item.style.display = visible ? "" : "none";
          if (visible) sectionHasMatch = true;
        });

        section.style.display = sectionHasMatch ? "" : "none";
        if (sectionHasMatch) anyVisible = true;
      });

      if (empty) empty.classList.toggle("is-visible", !anyVisible);
    }

    search.addEventListener("input", apply);

    chips.forEach((chip) => {
      chip.addEventListener("click", () => {
        chips.forEach((c) => c.classList.remove("is-active"));
        chip.classList.add("is-active");
        activeFilter = chip.dataset.filter;
        apply();
      });
    });
  }

  document.addEventListener("DOMContentLoaded", setupFilters);
})();
