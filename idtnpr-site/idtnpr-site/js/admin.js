/**
 * admin.js
 * -----------------------------------------------------------------------
 * Monta o formulário de /admin.html a partir de CONTENT_SCHEMA (content.js)
 * e salva as edições no localStorage, sob a chave CONTENT_STORAGE_KEY.
 *
 * Como as páginas do site (site.js) leem essa mesma chave, o que for
 * salvo aqui aparece automaticamente no site — no mesmo navegador.
 *
 * IMPORTANTE: isso é armazenamento local do navegador, não um banco de
 * dados. Ele fica salvo só nesse computador/navegador. Para publicar as
 * mudanças pra todo mundo, use o botão "Exportar textos (.json)" e envie
 * o arquivo pra quem for aplicar as mudanças no código-fonte definitivo.
 * -----------------------------------------------------------------------
 */

(function () {
  const form = document.getElementById("admin-form");
  const statusEl = document.getElementById("admin-status");
  const defaults = getDefaultsMap();

  function loadOverrides() {
    try {
      return JSON.parse(localStorage.getItem(CONTENT_STORAGE_KEY)) || {};
    } catch (e) {
      return {};
    }
  }

  function saveOverrides(overrides) {
    localStorage.setItem(CONTENT_STORAGE_KEY, JSON.stringify(overrides));
  }

  function fieldId(key) {
    return "field-" + key.replace(/[^a-zA-Z0-9]/g, "-");
  }

  function buildForm() {
    const overrides = loadOverrides();

    CONTENT_SCHEMA.forEach((page) => {
      const pageSection = document.createElement("details");
      pageSection.className = "admin-page";
      pageSection.open = page.page === "home";

      const pageSummary = document.createElement("summary");
      pageSummary.innerHTML = `<span>${page.pageLabel}</span><span class="admin-page-count">${countFields(page)} campos</span>`;
      pageSection.appendChild(pageSummary);

      page.groups.forEach((group) => {
        const groupBlock = document.createElement("div");
        groupBlock.className = "admin-group";

        const groupTitle = document.createElement("h3");
        groupTitle.textContent = group.label;
        groupBlock.appendChild(groupTitle);

        group.fields.forEach((field) => {
          const row = document.createElement("div");
          row.className = "admin-field";

          const label = document.createElement("label");
          label.textContent = field.label;
          label.htmlFor = fieldId(field.key);

          const currentValue = Object.prototype.hasOwnProperty.call(overrides, field.key)
            ? overrides[field.key]
            : field.default;

          let input;
          if (field.long) {
            input = document.createElement("textarea");
            input.rows = 3;
          } else {
            input = document.createElement("input");
            input.type = "text";
          }
          input.id = fieldId(field.key);
          input.name = field.key;
          input.value = currentValue;
          input.dataset.key = field.key;
          input.dataset.default = field.default;

          row.appendChild(label);
          row.appendChild(input);
          groupBlock.appendChild(row);
        });

        pageSection.appendChild(groupBlock);
      });

      form.appendChild(pageSection);
    });
  }

  function countFields(page) {
    return page.groups.reduce((total, g) => total + g.fields.length, 0);
  }

  function showStatus(message) {
    statusEl.textContent = message;
    statusEl.classList.add("is-visible");
    clearTimeout(showStatus._t);
    showStatus._t = setTimeout(() => statusEl.classList.remove("is-visible"), 2600);
  }

  function handleSave(e) {
    e.preventDefault();
    const overrides = {};
    form.querySelectorAll("[data-key]").forEach((input) => {
      overrides[input.dataset.key] = input.value;
    });
    saveOverrides(overrides);
    showStatus("Alterações salvas neste navegador.");
  }

  function handleReset() {
    if (!confirm("Restaurar todos os textos para o padrão original? Isso apaga as edições salvas neste navegador.")) return;
    localStorage.removeItem(CONTENT_STORAGE_KEY);
    form.querySelectorAll("[data-key]").forEach((input) => {
      input.value = input.dataset.default;
    });
    showStatus("Textos restaurados para o padrão.");
  }

  function handleExport() {
    const overrides = {};
    form.querySelectorAll("[data-key]").forEach((input) => {
      overrides[input.dataset.key] = input.value;
    });
    const blob = new Blob([JSON.stringify(overrides, null, 2)], { type: "application/json" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "idtnpr-textos-editados.json";
    a.click();
    URL.revokeObjectURL(url);
  }

  function handleSearch(e) {
    const term = e.target.value.trim().toLowerCase();
    form.querySelectorAll(".admin-field").forEach((row) => {
      const label = row.querySelector("label").textContent.toLowerCase();
      const value = row.querySelector("[data-key]").value.toLowerCase();
      const match = !term || label.includes(term) || value.includes(term);
      row.style.display = match ? "" : "none";
    });
    // abre automaticamente as páginas/grupos que tiverem resultado durante a busca
    if (term) {
      form.querySelectorAll("details.admin-page").forEach((d) => (d.open = true));
    }
  }

  document.addEventListener("DOMContentLoaded", () => {
    buildForm();
    form.addEventListener("submit", handleSave);
    document.getElementById("btn-reset").addEventListener("click", handleReset);
    document.getElementById("btn-export").addEventListener("click", handleExport);
    document.getElementById("admin-search").addEventListener("input", handleSearch);
  });
})();
