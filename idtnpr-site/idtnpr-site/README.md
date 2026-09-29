# IDTNPR — Site institucional

Site em HTML/CSS/JavaScript puro (sem framework, sem build). Basta abrir
os arquivos .html num navegador ou hospedar a pasta em qualquer servidor
estático.

## Estrutura de pastas

```
idtnpr-site/
├── index.html          → página inicial
├── admin.html           → painel de edição de textos
├── css/
│   ├── style.css        → estilo do site público (todas as páginas)
│   └── admin.css         → estilo só do painel de edição
├── js/
│   ├── content.js        → TODOS os textos editáveis do site (fonte única)
│   ├── site.js            → aplica os textos editados + liga o menu mobile
│   └── admin.js            → monta o formulário do painel e salva as edições
├── assets/
│   └── logo.png
└── README.md
```

## Como o "botão de editar textos" funciona

1. No site, clique em **"✎ Editar textos"** no topo — isso abre `admin.html`.
2. No painel, altere qualquer campo e clique em **Salvar alterações**.
3. As mudanças ficam salvas no `localStorage` do navegador (não é um banco
   de dados nem vai para um servidor) e aparecem no site imediatamente,
   mas só nesse navegador/computador.
4. Quando o texto estiver pronto, clique em **Exportar textos (.json)** e
   envie o arquivo pra quem for aplicar as mudanças no código-fonte
   definitivo (trocando o valor `default` de cada campo em `content.js`).
5. **Restaurar padrão** apaga as edições salvas e volta pro texto original.

Isso é intencional para um projeto de extensão: dá pra qualquer pessoa da
equipe testar textos novos sem precisar mexer em código, e o `.json`
exportado serve como "pedido de alteração" documentado para quem for
publicar de verdade.

## Como adicionar uma nova página (ex: atuacao.html)

1. Copie `index.html` e renomeie para a nova página (ex: `atuacao.html`).
   Isso já traz pronto: cabeçalho, menu, botão "Editar textos", rodapé e os
   `<link>`/`<script>` necessários.
2. Apague as `<section>` do `<main>` e escreva o conteúdo da nova página.
3. Para cada texto que deve ser editável no painel, adicione o atributo
   `data-edit-id="algumaChave"` no elemento (siga o padrão
   `nomedapagina.secao.campo`, ex: `atuacao.hero.title`).
4. Abra `js/content.js` e adicione um novo bloco dentro de `CONTENT_SCHEMA`,
   com `page: "atuacao"` e os mesmos campos que você marcou no HTML,
   cada um com uma `key` igual ao `data-edit-id` usado e um `default`
   com o texto original.
5. Pronto — não precisa mexer em `admin.html` nem `admin.js`: o painel lê
   `content.js` automaticamente e a nova página aparece lá sozinha.
6. Adicione o link para a nova página no menu (`index.html` e nas demais
   páginas) e no rodapé, se fizer sentido.

## Classes e componentes reaproveitáveis (`style.css`)

- `.btn`, `.btn-primary`, `.btn-outline`, `.btn-gold` → botões
- `.section-head` + `.kicker` → cabeçalho de seção (selo + título + subtítulo)
- `.card` / `.cards-grid` → grade de cartões
- `.compare` → tabela comparativa (usada na home, "o que trava")
- `.step` / `.steps-track` → cartões de etapas/processo
- `.stat` / `.stats-grid` → números em destaque
- `section.alt` → alterna o fundo da seção para cinza-claro (`--mist`)

Use essas classes nas páginas novas para manter a identidade visual sem
duplicar CSS. Se precisar de um componente novo, adicione o estilo dele
em `style.css`, no bloco correspondente, comentado.

## Cores e tipografia (tokens em `:root`, no topo de `style.css`)

| Token | Uso |
|---|---|
| `--navy` / `--navy-dark` | cor principal da marca (títulos, botões, header) |
| `--gold` | cor de destaque (selos, links, ícones) |
| `--ink` / `--ink-soft` | texto principal / texto secundário |
| `--mist` / `--mist-dark` | fundos claros |
| `--serif` (Libre Baskerville) | títulos |
| `--sans` (IBM Plex Sans) | texto corrido, botões, menu |

## Observações técnicas

- Sem dependências externas além das duas fontes do Google Fonts.
- `content.js` precisa ser carregado **antes** de `site.js` (na página
  pública) ou de `admin.js` (no painel) — ambos dependem dele.
- O painel (`admin.html`) tem `<meta name="robots" content="noindex, nofollow">`
  para não ser indexado por buscadores.
- Compatível com qualquer hospedagem estática (Netlify, Vercel, GitHub
  Pages, Apache, Nginx etc.) — não precisa de Node, PHP ou banco de dados.
