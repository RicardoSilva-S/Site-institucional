/**
 * content.js
 * -----------------------------------------------------------------------
 * FONTE ÚNICA DE TODOS OS TEXTOS EDITÁVEIS DO SITE.
 *
 * Cada campo tem uma "key" (ex: "home.hero.title") que é usada em dois lugares:
 *   1. No HTML, como atributo:  data-edit-id="home.hero.title"
 *   2. Aqui, como valor padrão.
 *
 * O painel /admin.html lê este arquivo para montar o formulário de edição.
 * O site (index.html, etc.) lê este arquivo + o que foi salvo no navegador
 * (localStorage) para decidir qual texto mostrar.
 *
 * ---------------------------------------------------------------------
 * COMO ADICIONAR UMA NOVA PÁGINA (ex: atuacao.html)
 * ---------------------------------------------------------------------
 * 1. Copie o cabeçalho/rodapé de index.html para a nova página (eles usam
 *    as keys "shared.*", então não precisam ser recriados).
 * 2. Adicione um novo objeto dentro de CONTENT_SCHEMA, com page: "atuacao".
 * 3. Dê um prefixo próprio pras keys, ex: "atuacao.hero.title".
 * 4. No HTML da nova página, adicione data-edit-id="atuacao.hero.title"
 *    no elemento correspondente.
 * 5. No final do <body>, inclua:
 *      <script src="js/content.js"></script>
 *      <script src="js/site.js"></script>
 * 6. Pronto — o painel admin já vai mostrar a nova página automaticamente,
 *    sem precisar mexer em admin.html ou admin.js.
 * ---------------------------------------------------------------------
 */

const CONTENT_SCHEMA = [
  {
    page: "shared",
    pageLabel: "Compartilhado (menu e rodapé — aparece em todas as páginas)",
    groups: [
      {
        id: "nav",
        label: "Menu de navegação",
        fields: [
          { key: "shared.nav.inicio", label: "Item do menu: Início", default: "Início" },
          { key: "shared.nav.institucional", label: "Item do menu: Institucional", default: "Institucional" },
          { key: "shared.nav.atuacao", label: "Item do menu: Atuação", default: "Atuação" },
          { key: "shared.nav.projetos", label: "Item do menu: Projetos", default: "Projetos" },
          { key: "shared.nav.editais", label: "Item do menu: Editais", default: "Editais" },
          { key: "shared.nav.transparencia", label: "Item do menu: Transparência", default: "Transparência" },
          { key: "shared.nav.contato", label: "Item do menu: Contato", default: "Contato" },
          { key: "shared.nav.cta", label: "Botão do topo", default: "Fale com o Instituto" },
        ],
      },
      {
        id: "footer",
        label: "Rodapé",
        fields: [
          { key: "shared.footer.about", label: "Texto sobre o Instituto", default: "Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense. Associação civil de direito privado sem fins lucrativos. CNPJ 64.039.593/0001-82", long: true },
          { key: "shared.footer.col1.title", label: "Título da coluna 1", default: "Institucional" },
          { key: "shared.footer.col2.title", label: "Título da coluna 2", default: "Soluções" },
          { key: "shared.footer.col3.title", label: "Título da coluna 3", default: "Transparência" },
          { key: "shared.footer.bottom.left", label: "Rodapé — linha esquerda", default: "© 2026 IDTNPR · Sarandi, Paraná" },
          { key: "shared.footer.bottom.right", label: "Rodapé — endereço/e-mail", default: "Rua João Marangoni, 2908, Casa 7 · Sarandi/PR · faleconosco@idtnpr.org.br" },
        ],
      },
    ],
  },
  {
    page: "home",
    pageLabel: "Página inicial (index.html)",
    groups: [
      {
        id: "hero",
        label: "Topo (Hero)",
        fields: [
          { key: "home.hero.eyebrow", label: "Selo acima do título", default: "Instituição de Ciência e Tecnologia · ICT" },
          { key: "home.hero.title", label: "Título principal", default: "O hub de tecnologia da administração pública", long: true },
          { key: "home.hero.lead", label: "Texto de apoio", default: "Reunimos, em uma só instituição, as soluções tecnológicas que a prefeitura e a câmara precisam, junto com o caminho jurídico que permite contratá-las.", long: true },
          { key: "home.hero.cta1", label: "Botão principal", default: "Solicitar diagnóstico gratuito" },
          { key: "home.hero.cta2", label: "Botão secundário", default: "Ver as soluções" },
          { key: "home.hero.fact1", label: "Selo 1", default: "Um só interlocutor para a prefeitura e a câmara" },
          { key: "home.hero.fact2", label: "Selo 2", default: "Enquadramento jurídico definido caso a caso" },
          { key: "home.hero.fact3", label: "Selo 3", default: "Instituição de Ciência e Tecnologia (ICT) reconhecida" },
          { key: "home.hero.fact4", label: "Selo 4", default: "Associação sem fins lucrativos de atuação nacional, com foco no Paraná" },
        ],
      },
      {
        id: "catalog",
        label: "Cartão \"Catálogo de soluções\"",
        fields: [
          { key: "home.catalog.tag", label: "Selo do cartão", default: "hub ativo" },
          { key: "home.catalog.title", label: "Título do cartão", default: "Catálogo de soluções" },
          { key: "home.catalog.item1.label", label: "Item 1 — nome", default: "Totem de autoatendimento" },
          { key: "home.catalog.item1.cat", label: "Item 1 — categoria", default: "Atendimento" },
          { key: "home.catalog.item2.label", label: "Item 2 — nome", default: "Manutenção municipal" },
          { key: "home.catalog.item2.cat", label: "Item 2 — categoria", default: "Gestão" },
          { key: "home.catalog.item3.label", label: "Item 3 — nome", default: "Notas contra o município" },
          { key: "home.catalog.item3.cat", label: "Item 3 — categoria", default: "Fiscal" },
          { key: "home.catalog.item4.label", label: "Item 4 — nome", default: "Alô Câmara" },
          { key: "home.catalog.item4.cat", label: "Item 4 — categoria", default: "Legislativo" },
          { key: "home.catalog.item5.label", label: "Item 5 — nome", default: "Lei Municipal de Inovação" },
          { key: "home.catalog.item5.cat", label: "Item 5 — categoria", default: "Jurídico" },
          { key: "home.catalog.item6.label", label: "Item 6 — nome", default: "Capacitação de servidores" },
          { key: "home.catalog.item6.cat", label: "Item 6 — categoria", default: "Formação" },
        ],
      },
      {
        id: "problem",
        label: "Seção \"O problema\"",
        fields: [
          { key: "home.problem.kicker", label: "Selo da seção", default: "O problema" },
          { key: "home.problem.title", label: "Título", default: "Contratar tecnologia é o que mais trava na prefeitura", long: true },
          { key: "home.problem.text", label: "Parágrafo principal", default: "A solução já existe no mercado. Falta quem traduza o problema em especificação técnica, saiba por qual lei aquilo pode ser contratado e acompanhe até o sistema estar funcionando.", long: true },
          { key: "home.problem.more1", label: "Parágrafo extra 1 (\"Continuar lendo\")", default: "Prefeitura pequena quase nunca tem equipe de tecnologia para redigir o termo de referência de um sistema. Sem isso, o certame fracassa por falta de interessados ou é vencido por quem entrega menos, e o município fica com um software que ninguém usa.", long: true },
          { key: "home.problem.more2", label: "Parágrafo extra 2", default: "Há ainda os casos em que licitação nenhuma resolve: a solução é nova, precisa ser testada antes de comprada, ou o desenvolvedor não participa de licitação. Para cada um deles a lei já tem um caminho. Falta quem conheça.", long: true },
          { key: "home.problem.link", label: "Link ao final", default: "Conheça as seis portas legais" },
        ],
      },
      {
        id: "compare",
        label: "Tabela comparativa",
        fields: [
          { key: "home.compare.head.left", label: "Cabeçalho — coluna esquerda", default: "O que trava" },
          { key: "home.compare.head.right", label: "Cabeçalho — coluna direita", default: "O que entregamos" },
          { key: "home.compare.row1.bad", label: "Linha 1 — problema", default: "Fila no atendimento" },
          { key: "home.compare.row1.good", label: "Linha 1 — solução", default: "IDTNPR — hub de soluções" },
          { key: "home.compare.row2.bad", label: "Linha 2 — problema", default: "Manutenção sem controle" },
          { key: "home.compare.row2.good", label: "Linha 2 — solução", default: "Solução definida, com custo estimado" },
          { key: "home.compare.row3.bad", label: "Linha 3 — problema", default: "Notas sem conferência" },
          { key: "home.compare.row3.good", label: "Linha 3 — solução", default: "Instrumento legal, com minuta pronta" },
          { key: "home.compare.row4.bad", label: "Linha 4 — problema", default: "Sessão sem transmissão" },
          { key: "home.compare.row4.good", label: "Linha 4 — solução", default: "Implantação e prestação de contas" },
        ],
      },
      {
        id: "steps",
        label: "Seção \"Como funciona\" (5 etapas)",
        fields: [
          { key: "home.steps.kicker", label: "Selo da seção", default: "Como funciona" },
          { key: "home.steps.title", label: "Título", default: "Do problema ao sistema funcionando", long: true },
          { key: "home.steps.sub", label: "Subtítulo", default: "Todo projeto de tecnologia percorre o mesmo rito, em qualquer município. É isso que dá previsibilidade ao gestor e segurança ao controle.", long: true },
          { key: "home.steps.hint", label: "Dica de arrastar", default: "Arraste para o lado para ver as cinco etapas →" },
          { key: "home.step1.title", label: "Etapa 1 — título", default: "Diagnóstico técnico" },
          { key: "home.step1.desc", label: "Etapa 1 — descrição", default: "Levantamos os sistemas em uso, medimos onde o processo trava e apontamos o que pode ser digitalizado ou automatizado.", long: true },
          { key: "home.step1.free", label: "Etapa 1 — selo", default: "Sem custo" },
          { key: "home.step2.title", label: "Etapa 2 — título", default: "Solução e enquadramento" },
          { key: "home.step2.desc", label: "Etapa 2 — descrição", default: "Indicamos a solução adequada e o instrumento legal que permite contratá-la, com minuta e fundamentação para a Procuradoria.", long: true },
          { key: "home.step2.free", label: "Etapa 2 — selo", default: "Sem custo" },
          { key: "home.step3.title", label: "Etapa 3 — título", default: "Formalização" },
          { key: "home.step3.desc", label: "Etapa 3 — descrição", default: "O município instaura o processo, publica e assina. Quem decide é sempre a Administração.", long: true },
          { key: "home.step4.title", label: "Etapa 4 — título", default: "Implantação" },
          { key: "home.step4.desc", label: "Etapa 4 — descrição", default: "Instalação, integração com os sistemas já existentes, migração de dados e treinamento dos servidores que vão operar.", long: true },
          { key: "home.step5.title", label: "Etapa 5 — título", default: "Operação e contas" },
          { key: "home.step5.desc", label: "Etapa 5 — descrição", default: "Suporte, indicadores de uso e relatório periódico entregue ao município e publicado neste portal.", long: true },
        ],
      },
      {
        id: "cards",
        label: "Seção \"Como atuamos\" (cartões)",
        fields: [
          { key: "home.cards.kicker", label: "Selo da seção", default: "Como atuamos" },
          { key: "home.cards.title", label: "Título", default: "Um hub de soluções para o poder público", long: true },
          { key: "home.cards.sub", label: "Subtítulo", default: "O Instituto reúne, sob uma única instituição, as soluções tecnológicas desenvolvidas por seus parceiros e as entrega às entidades públicas pelo instrumento jurídico adequado a cada caso.", long: true },
          { key: "home.card1.kicker", label: "Cartão 1 — selo", default: "Política pública estruturante" },
          { key: "home.card1.title", label: "Cartão 1 — título", default: "Marco legal de inovação municipal", long: true },
          { key: "home.card1.desc", label: "Cartão 1 — texto", default: "Lei Municipal de CT&I, decreto de regulamentação, regimento do Conselho e desenho do Fundo Municipal de Inovação. Acesso ao fomento estadual, inclusive o repasse fundo a fundo da Lei Estadual/PR nº 22.107/2024.", long: true },
          { key: "home.card2.kicker", label: "Cartão 2 — selo", default: "Gestão por evidências" },
          { key: "home.card2.title", label: "Cartão 2 — título", default: "Observatório de dados municipais", long: true },
          { key: "home.card2.desc", label: "Cartão 2 — texto", default: "Painéis de indicadores, integração de bases públicas e leitura analítica para decisão. O gestor decide com número; o cidadão enxerga o resultado.", long: true },
          { key: "home.card3.kicker", label: "Cartão 3 — selo", default: "Estruturação" },
          { key: "home.card3.title", label: "Cartão 3 — título", default: "Governança e modernização", long: true },
          { key: "home.card3.desc", label: "Cartão 3 — texto", default: "Diagnóstico de maturidade digital, redesenho de processos, políticas internas e adequação à LGPD.", long: true },
          { key: "home.card4.kicker", label: "Cartão 4 — selo", default: "Execução" },
          { key: "home.card4.title", label: "Cartão 4 — título", default: "PMO público", long: true },
          { key: "home.card4.desc", label: "Cartão 4 — texto", default: "Portfólio, cronograma, indicadores e apoio técnico ao fiscal do contrato, na forma do art. 117 da Lei nº 14.133/2021.", long: true },
          { key: "home.card5.kicker", label: "Cartão 5 — selo", default: "Formação" },
          { key: "home.card5.title", label: "Cartão 5 — título", default: "Capacitação de servidores", long: true },
          { key: "home.card5.desc", label: "Cartão 5 — texto", default: "Nova Lei de Licitações, LGPD, governo digital, rotinas tributárias e contábeis e Marco Legal de CT&I.", long: true },
          { key: "home.card6.kicker", label: "Cartão 6 — selo", default: "Testar antes de comprar" },
          { key: "home.card6.title", label: "Cartão 6 — título", default: "Aplicações piloto e PD&I", long: true },
          { key: "home.card6.desc", label: "Cartão 6 — texto", default: "Chamamento público aberto a qualquer interessado, acordo de parceria para pesquisa e desenvolvimento e relatório técnico ao final.", long: true },
          { key: "home.cards.note", label: "Nota abaixo dos cartões", default: "Há ainda três frentes: PMO público, capacitação de servidores e aplicações piloto de PD&I.", long: true },
          { key: "home.cards.cta1", label: "Link 1", default: "Ver os projetos e produtos" },
          { key: "home.cards.cta2", label: "Link 2", default: "Ver cada frente em detalhe" },
        ],
      },
      {
        id: "stats",
        label: "Seção \"Por que pelo Instituto\"",
        fields: [
          { key: "home.stats.kicker", label: "Selo da seção", default: "Por que pelo Instituto" },
          { key: "home.stats.title", label: "Título", default: "Mais rápido, mais prático e mais seguro", long: true },
          { key: "home.stat1.num", label: "Número 1", default: "6" },
          { key: "home.stat1.label", label: "Legenda 1", default: "instrumentos legais de contratação mapeados, cada um com a norma que o autoriza", long: true },
          { key: "home.stat2.num", label: "Número 2", default: "6" },
          { key: "home.stat2.label", label: "Legenda 2", default: "soluções no catálogo do Instituto, entre produtos de parceiros e serviços próprios", long: true },
          { key: "home.stat3.num", label: "Número 3", default: "R$ 0" },
          { key: "home.stat3.label", label: "Legenda 3", default: "de custo para o diagnóstico técnico e o enquadramento jurídico", long: true },
          { key: "home.stat4.num", label: "Número 4", default: "100%" },
          { key: "home.stat4.label", label: "Legenda 4", default: "dos projetos com instrumento jurídico formalizado antes da execução", long: true },
          { key: "home.rite1.title", label: "Etapa 1 (faixa)", default: "Diagnóstico" },
          { key: "home.rite1.sub", label: "Etapa 1 (faixa) — legenda", default: "sem custo" },
          { key: "home.rite2.title", label: "Etapa 2 (faixa)", default: "Enquadramento" },
          { key: "home.rite2.sub", label: "Etapa 2 (faixa) — legenda", default: "sem custo" },
          { key: "home.rite3.title", label: "Etapa 3 (faixa)", default: "Formalização" },
          { key: "home.rite3.sub", label: "Etapa 3 (faixa) — legenda", default: "o município conduz" },
          { key: "home.rite4.title", label: "Etapa 4 (faixa)", default: "Implantação" },
          { key: "home.rite4.sub", label: "Etapa 4 (faixa) — legenda", default: "metas e indicadores" },
          { key: "home.rite5.title", label: "Etapa 5 (faixa)", default: "Operação" },
          { key: "home.rite5.sub", label: "Etapa 5 (faixa) — legenda", default: "com prestação de contas" },
          { key: "home.stats.copy1", label: "Parágrafo 1", default: "Mais rápido porque o diagnóstico técnico e a fundamentação jurídica chegam prontos à Procuradoria, em vez de serem construídos do zero dentro da prefeitura. Mais prático porque o município trata com um único interlocutor técnico, e não com um fornecedor para cada problema.", long: true },
          { key: "home.stats.copy2", label: "Parágrafo 2", default: "Mais seguro não significa menos controle. Significa antecipá-lo. O gestor que contrata por aqui termina com mais documentação: diagnóstico técnico, fundamentação jurídica, plano de trabalho com indicadores, relatórios periódicos e prestação de contas publicada.", long: true },
          { key: "home.stats.cta", label: "Botão", default: "Conheça a base legal" },
        ],
      },
      {
        id: "transp",
        label: "Seção \"Transparência\"",
        fields: [
          { key: "home.transp.kicker", label: "Selo da seção", default: "Transparência" },
          { key: "home.transp.title", label: "Título", default: "Documentação pública e oficial", long: true },
          { key: "home.transp.text", label: "Texto", default: "Estatuto Social, atas registradas em cartório, regimento interno, CNPJ e termos de parceria. Caso queira acesso a toda a documentação, clique aqui.", long: true },
          { key: "home.transp.cta", label: "Botão", default: "Solicitar documentos institucionais" },
          { key: "home.transp.item1.title", label: "Cartão 1 — título", default: "Institucional" },
          { key: "home.transp.item1.desc", label: "Cartão 1 — texto", default: "Estatuto, atas registradas, regimento e CNPJ" },
          { key: "home.transp.item2.title", label: "Cartão 2 — título", default: "Normativos" },
          { key: "home.transp.item2.desc", label: "Cartão 2 — texto", default: "Regulamentos, código de ética e políticas" },
          { key: "home.transp.item3.title", label: "Cartão 3 — título", default: "Parcerias" },
          { key: "home.transp.item3.desc", label: "Cartão 3 — texto", default: "Termos e acordos firmados pelo Instituto" },
          { key: "home.transp.item4.title", label: "Cartão 4 — título", default: "Prestação de contas" },
          { key: "home.transp.item4.desc", label: "Cartão 4 — texto", default: "Relatórios, demonstrativos e pareceres" },
        ],
      },
      {
        id: "finalcta",
        label: "Chamada final",
        fields: [
          { key: "home.finalcta.title", label: "Título", default: "Comece pelo diagnóstico, sem custo", long: true },
          { key: "home.finalcta.text", label: "Texto", default: "Conte qual é o problema do seu município. Medimos, apresentamos as alternativas e indicamos o caminho legal. Se o caso for de licitação comum, nós dizemos que é de licitação comum.", long: true },
          { key: "home.finalcta.button", label: "Botão", default: "Falar com o Instituto" },
        ],
      },
    ],
  },
];

/** Achata o schema acima num mapa simples { key: valorPadrao } */
function getDefaultsMap() {
  const map = {};
  CONTENT_SCHEMA.forEach((page) => {
    page.groups.forEach((group) => {
      group.fields.forEach((field) => {
        map[field.key] = field.default;
      });
    });
  });
  return map;
}

const CONTENT_STORAGE_KEY = "idtnpr_content_overrides";
