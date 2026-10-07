<?php

/**
 * Fonte única de todos os textos editáveis do site (config/site_content.php).
 *
 * Portado 1:1 do antigo js/content.js (CONTENT_SCHEMA). Cada campo tem uma
 * "key" única (ex: "home.hero.title") usada por:
 *   - App\Support\SiteContent::text($key) nas views Blade, via @content($key)
 *   - o painel /admin/conteudo, para montar o formulário de edição
 *
  * O valor exibido é o override salvo na tabela site_content_values, ou este
 * "default" quando não houver override.
 *
 * Os textos são copiados daqui para a tabela site_texts (migration
 * create_site_texts_table / SiteContent::sync()). Depois disso, o que vale é
 * o banco: o painel /adm edita, insere e exclui textos lá. Este arquivo
 * continua sendo o "texto original" de cada campo.
 *
 * "route" é o nome da rota da página (routes/web.php) — usado pelos banners.
 *
 * "banner" num grupo (seção) cria uma posição de imagem ao lado dela, com o
 * caminho da imagem padrão (relativo a public/). A imagem pode ser trocada em
 * /adm/banners ou no próprio editor da página — ver App\Support\BannerSlots.
 *
 * COMO ADICIONAR UMA NOVA PÁGINA:
 * 1. Copie resources/views/site/home.blade.php para a nova página.
 * 2. Adicione um novo item aqui, com "page" => "nome-da-pagina".
 * 3. Use @content("nome-da-pagina.secao.campo") na nova view.
 * 4. Adicione a rota em routes/web.php.
 * O painel /adm mostra a nova página no menu lateral automaticamente.
 */

return [
    [
        'page' => 'shared',
        'pageLabel' => 'Menu e rodapé',
        'route' => null,
        'groups' => [
            [
                'id' => 'nav',
                'label' => 'Menu de navegação',
                'fields' => [
                    [
                        'key' => 'shared.nav.inicio',
                        'label' => 'Item do menu: Início',
                        'default' => 'Início',
                    ],
                    [
                        'key' => 'shared.nav.institucional',
                        'label' => 'Item do menu: Institucional',
                        'default' => 'Institucional',
                    ],
                    [
                        'key' => 'shared.nav.atuacao',
                        'label' => 'Item do menu: Atuação',
                        'default' => 'Atuação',
                    ],
                    [
                        'key' => 'shared.nav.projetos',
                        'label' => 'Item do menu: Projetos',
                        'default' => 'Projetos',
                    ],
                    [
                        'key' => 'shared.nav.editais',
                        'label' => 'Item do menu: Editais',
                        'default' => 'Editais',
                    ],
                    [
                        'key' => 'shared.nav.transparencia',
                        'label' => 'Item do menu: Transparência',
                        'default' => 'Transparência',
                    ],
                    [
                        'key' => 'shared.nav.contato',
                        'label' => 'Item do menu: Contato',
                        'default' => 'Contato',
                    ],
                    [
                        'key' => 'shared.nav.cta',
                        'label' => 'Botão do topo',
                        'default' => 'Fale com o Instituto',
                    ],
                ],
            ],
            [
                'id' => 'footer',
                'label' => 'Rodapé',
                'fields' => [
                    [
                        'key' => 'shared.footer.about',
                        'label' => 'Texto sobre o Instituto',
                        'default' => 'Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense. Associação civil de direito privado sem fins lucrativos. CNPJ 64.039.593/0001-82',
                        'long' => true,
                    ],
                    [
                        'key' => 'shared.footer.col1.title',
                        'label' => 'Título da coluna 1',
                        'default' => 'Institucional',
                    ],
                    [
                        'key' => 'shared.footer.col2.title',
                        'label' => 'Título da coluna 2',
                        'default' => 'Soluções',
                    ],
                    [
                        'key' => 'shared.footer.col3.title',
                        'label' => 'Título da coluna 3',
                        'default' => 'Transparência',
                    ],
                    [
                        'key' => 'shared.footer.bottom.left',
                        'label' => 'Rodapé — linha esquerda',
                        'default' => '© 2026 IDTNPR · Sarandi, Paraná',
                    ],
                    [
                        'key' => 'shared.footer.bottom.right',
                        'label' => 'Rodapé — endereço/e-mail',
                        'default' => 'Rua João Marangoni, 2908, Casa 7 · Sarandi/PR · faleconosco@idtnpr.org.br',
                    ],
                ],
            ],
        ],
    ],
    [
        'page' => 'home',
        'pageLabel' => 'Início',
        'route' => 'home',
        'groups' => [
            [
                'id' => 'hero',
                'label' => 'Topo (Hero)',
                'fields' => [
                    [
                        'key' => 'home.hero.eyebrow',
                        'label' => 'Selo acima do título',
                        'default' => 'Instituição de Ciência e Tecnologia · ICT',
                    ],
                    [
                        'key' => 'home.hero.title',
                        'label' => 'Título principal',
                        'default' => 'O hub de tecnologia da administração pública',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.hero.lead',
                        'label' => 'Texto de apoio',
                        'default' => 'Reunimos, em uma só instituição, as soluções tecnológicas que a prefeitura e a câmara precisam, junto com o caminho jurídico que permite contratá-las.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.hero.cta1',
                        'label' => 'Botão principal',
                        'default' => 'Solicitar diagnóstico gratuito',
                    ],
                    [
                        'key' => 'home.hero.cta2',
                        'label' => 'Botão secundário',
                        'default' => 'Ver as soluções',
                    ],
                    [
                        'key' => 'home.hero.fact1',
                        'label' => 'Selo 1',
                        'default' => 'Um só interlocutor para a prefeitura e a câmara',
                    ],
                    [
                        'key' => 'home.hero.fact2',
                        'label' => 'Selo 2',
                        'default' => 'Enquadramento jurídico definido caso a caso',
                    ],
                    [
                        'key' => 'home.hero.fact3',
                        'label' => 'Selo 3',
                        'default' => 'Instituição de Ciência e Tecnologia (ICT) reconhecida',
                    ],
                    [
                        'key' => 'home.hero.fact4',
                        'label' => 'Selo 4',
                        'default' => 'Associação sem fins lucrativos de atuação nacional, com foco no Paraná',
                    ],
                ],
            ],
            [
                'id' => 'catalog',
                'label' => 'Cartão "Catálogo de soluções"',
                'fields' => [
                    [
                        'key' => 'home.catalog.tag',
                        'label' => 'Selo do cartão',
                        'default' => 'hub ativo',
                    ],
                    [
                        'key' => 'home.catalog.title',
                        'label' => 'Título do cartão',
                        'default' => 'Catálogo de soluções',
                    ],
                    [
                        'key' => 'home.catalog.item1.label',
                        'label' => 'Item 1 — nome',
                        'default' => 'Totem de autoatendimento',
                    ],
                    [
                        'key' => 'home.catalog.item1.cat',
                        'label' => 'Item 1 — categoria',
                        'default' => 'Atendimento',
                    ],
                    [
                        'key' => 'home.catalog.item2.label',
                        'label' => 'Item 2 — nome',
                        'default' => 'Manutenção municipal',
                    ],
                    [
                        'key' => 'home.catalog.item2.cat',
                        'label' => 'Item 2 — categoria',
                        'default' => 'Gestão',
                    ],
                    [
                        'key' => 'home.catalog.item3.label',
                        'label' => 'Item 3 — nome',
                        'default' => 'Notas contra o município',
                    ],
                    [
                        'key' => 'home.catalog.item3.cat',
                        'label' => 'Item 3 — categoria',
                        'default' => 'Fiscal',
                    ],
                    [
                        'key' => 'home.catalog.item4.label',
                        'label' => 'Item 4 — nome',
                        'default' => 'Alô Câmara',
                    ],
                    [
                        'key' => 'home.catalog.item4.cat',
                        'label' => 'Item 4 — categoria',
                        'default' => 'Legislativo',
                    ],
                    [
                        'key' => 'home.catalog.item5.label',
                        'label' => 'Item 5 — nome',
                        'default' => 'Lei Municipal de Inovação',
                    ],
                    [
                        'key' => 'home.catalog.item5.cat',
                        'label' => 'Item 5 — categoria',
                        'default' => 'Jurídico',
                    ],
                    [
                        'key' => 'home.catalog.item6.label',
                        'label' => 'Item 6 — nome',
                        'default' => 'Capacitação de servidores',
                    ],
                    [
                        'key' => 'home.catalog.item6.cat',
                        'label' => 'Item 6 — categoria',
                        'default' => 'Formação',
                    ],
                ],
            ],
            [
                'id' => 'problem',
                'label' => 'Seção "O problema"',
                'fields' => [
                    [
                        'key' => 'home.problem.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'O problema',
                    ],
                    [
                        'key' => 'home.problem.title',
                        'label' => 'Título',
                        'default' => 'Contratar tecnologia é o que mais trava na prefeitura',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.problem.text',
                        'label' => 'Parágrafo principal',
                        'default' => 'A solução já existe no mercado. Falta quem traduza o problema em especificação técnica, saiba por qual lei aquilo pode ser contratado e acompanhe até o sistema estar funcionando.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.problem.more1',
                        'label' => 'Parágrafo extra 1 ("Continuar lendo")',
                        'default' => 'Prefeitura pequena quase nunca tem equipe de tecnologia para redigir o termo de referência de um sistema. Sem isso, o certame fracassa por falta de interessados ou é vencido por quem entrega menos, e o município fica com um software que ninguém usa.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.problem.more2',
                        'label' => 'Parágrafo extra 2',
                        'default' => 'Há ainda os casos em que licitação nenhuma resolve: a solução é nova, precisa ser testada antes de comprada, ou o desenvolvedor não participa de licitação. Para cada um deles a lei já tem um caminho. Falta quem conheça.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.problem.link',
                        'label' => 'Link ao final',
                        'default' => 'Conheça as seis portas legais',
                    ],
                ],
            ],
            [
                'id' => 'compare',
                'label' => 'Tabela comparativa',
                'fields' => [
                    [
                        'key' => 'home.compare.head.left',
                        'label' => 'Cabeçalho — coluna esquerda',
                        'default' => 'O que trava',
                    ],
                    [
                        'key' => 'home.compare.head.right',
                        'label' => 'Cabeçalho — coluna direita',
                        'default' => 'O que entregamos',
                    ],
                    [
                        'key' => 'home.compare.row1.bad',
                        'label' => 'Linha 1 — problema',
                        'default' => 'Fila no atendimento',
                    ],
                    [
                        'key' => 'home.compare.row1.good',
                        'label' => 'Linha 1 — solução',
                        'default' => 'IDTNPR — hub de soluções',
                    ],
                    [
                        'key' => 'home.compare.row2.bad',
                        'label' => 'Linha 2 — problema',
                        'default' => 'Manutenção sem controle',
                    ],
                    [
                        'key' => 'home.compare.row2.good',
                        'label' => 'Linha 2 — solução',
                        'default' => 'Solução definida, com custo estimado',
                    ],
                    [
                        'key' => 'home.compare.row3.bad',
                        'label' => 'Linha 3 — problema',
                        'default' => 'Notas sem conferência',
                    ],
                    [
                        'key' => 'home.compare.row3.good',
                        'label' => 'Linha 3 — solução',
                        'default' => 'Instrumento legal, com minuta pronta',
                    ],
                    [
                        'key' => 'home.compare.row4.bad',
                        'label' => 'Linha 4 — problema',
                        'default' => 'Sessão sem transmissão',
                    ],
                    [
                        'key' => 'home.compare.row4.good',
                        'label' => 'Linha 4 — solução',
                        'default' => 'Implantação e prestação de contas',
                    ],
                ],
            ],
            [
                'id' => 'steps',
                'label' => 'Seção "Como funciona" (5 etapas)',
                'fields' => [
                    [
                        'key' => 'home.steps.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Como funciona',
                    ],
                    [
                        'key' => 'home.steps.title',
                        'label' => 'Título',
                        'default' => 'Do problema ao sistema funcionando',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.steps.sub',
                        'label' => 'Subtítulo',
                        'default' => 'Todo projeto de tecnologia percorre o mesmo rito, em qualquer município. É isso que dá previsibilidade ao gestor e segurança ao controle.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.steps.hint',
                        'label' => 'Dica de arrastar',
                        'default' => 'Arraste para o lado para ver as cinco etapas →',
                    ],
                    [
                        'key' => 'home.step1.title',
                        'label' => 'Etapa 1 — título',
                        'default' => 'Diagnóstico técnico',
                    ],
                    [
                        'key' => 'home.step1.desc',
                        'label' => 'Etapa 1 — descrição',
                        'default' => 'Levantamos os sistemas em uso, medimos onde o processo trava e apontamos o que pode ser digitalizado ou automatizado.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.step1.free',
                        'label' => 'Etapa 1 — selo',
                        'default' => 'Sem custo',
                    ],
                    [
                        'key' => 'home.step2.title',
                        'label' => 'Etapa 2 — título',
                        'default' => 'Solução e enquadramento',
                    ],
                    [
                        'key' => 'home.step2.desc',
                        'label' => 'Etapa 2 — descrição',
                        'default' => 'Indicamos a solução adequada e o instrumento legal que permite contratá-la, com minuta e fundamentação para a Procuradoria.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.step2.free',
                        'label' => 'Etapa 2 — selo',
                        'default' => 'Sem custo',
                    ],
                    [
                        'key' => 'home.step3.title',
                        'label' => 'Etapa 3 — título',
                        'default' => 'Formalização',
                    ],
                    [
                        'key' => 'home.step3.desc',
                        'label' => 'Etapa 3 — descrição',
                        'default' => 'O município instaura o processo, publica e assina. Quem decide é sempre a Administração.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.step4.title',
                        'label' => 'Etapa 4 — título',
                        'default' => 'Implantação',
                    ],
                    [
                        'key' => 'home.step4.desc',
                        'label' => 'Etapa 4 — descrição',
                        'default' => 'Instalação, integração com os sistemas já existentes, migração de dados e treinamento dos servidores que vão operar.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.step5.title',
                        'label' => 'Etapa 5 — título',
                        'default' => 'Operação e contas',
                    ],
                    [
                        'key' => 'home.step5.desc',
                        'label' => 'Etapa 5 — descrição',
                        'default' => 'Suporte, indicadores de uso e relatório periódico entregue ao município e publicado neste portal.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'cards',
                'label' => 'Seção "Como atuamos" (cartões)',
                'fields' => [
                    [
                        'key' => 'home.cards.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Como atuamos',
                    ],
                    [
                        'key' => 'home.cards.title',
                        'label' => 'Título',
                        'default' => 'Um hub de soluções para o poder público',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.cards.sub',
                        'label' => 'Subtítulo',
                        'default' => 'O Instituto reúne, sob uma única instituição, as soluções tecnológicas desenvolvidas por seus parceiros e as entrega às entidades públicas pelo instrumento jurídico adequado a cada caso.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card1.kicker',
                        'label' => 'Cartão 1 — selo',
                        'default' => 'Política pública estruturante',
                    ],
                    [
                        'key' => 'home.card1.title',
                        'label' => 'Cartão 1 — título',
                        'default' => 'Marco legal de inovação municipal',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card1.desc',
                        'label' => 'Cartão 1 — texto',
                        'default' => 'Lei Municipal de CT&I, decreto de regulamentação, regimento do Conselho e desenho do Fundo Municipal de Inovação. Acesso ao fomento estadual, inclusive o repasse fundo a fundo da Lei Estadual/PR nº 22.107/2024.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card2.kicker',
                        'label' => 'Cartão 2 — selo',
                        'default' => 'Gestão por evidências',
                    ],
                    [
                        'key' => 'home.card2.title',
                        'label' => 'Cartão 2 — título',
                        'default' => 'Observatório de dados municipais',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card2.desc',
                        'label' => 'Cartão 2 — texto',
                        'default' => 'Painéis de indicadores, integração de bases públicas e leitura analítica para decisão. O gestor decide com número; o cidadão enxerga o resultado.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card3.kicker',
                        'label' => 'Cartão 3 — selo',
                        'default' => 'Estruturação',
                    ],
                    [
                        'key' => 'home.card3.title',
                        'label' => 'Cartão 3 — título',
                        'default' => 'Governança e modernização',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card3.desc',
                        'label' => 'Cartão 3 — texto',
                        'default' => 'Diagnóstico de maturidade digital, redesenho de processos, políticas internas e adequação à LGPD.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card4.kicker',
                        'label' => 'Cartão 4 — selo',
                        'default' => 'Execução',
                    ],
                    [
                        'key' => 'home.card4.title',
                        'label' => 'Cartão 4 — título',
                        'default' => 'PMO público',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card4.desc',
                        'label' => 'Cartão 4 — texto',
                        'default' => 'Portfólio, cronograma, indicadores e apoio técnico ao fiscal do contrato, na forma do art. 117 da Lei nº 14.133/2021.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card5.kicker',
                        'label' => 'Cartão 5 — selo',
                        'default' => 'Formação',
                    ],
                    [
                        'key' => 'home.card5.title',
                        'label' => 'Cartão 5 — título',
                        'default' => 'Capacitação de servidores',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card5.desc',
                        'label' => 'Cartão 5 — texto',
                        'default' => 'Nova Lei de Licitações, LGPD, governo digital, rotinas tributárias e contábeis e Marco Legal de CT&I.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card6.kicker',
                        'label' => 'Cartão 6 — selo',
                        'default' => 'Testar antes de comprar',
                    ],
                    [
                        'key' => 'home.card6.title',
                        'label' => 'Cartão 6 — título',
                        'default' => 'Aplicações piloto e PD&I',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.card6.desc',
                        'label' => 'Cartão 6 — texto',
                        'default' => 'Chamamento público aberto a qualquer interessado, acordo de parceria para pesquisa e desenvolvimento e relatório técnico ao final.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.cards.note',
                        'label' => 'Nota abaixo dos cartões',
                        'default' => 'Há ainda três frentes: PMO público, capacitação de servidores e aplicações piloto de PD&I.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.cards.cta1',
                        'label' => 'Link 1',
                        'default' => 'Ver os projetos e produtos',
                    ],
                    [
                        'key' => 'home.cards.cta2',
                        'label' => 'Link 2',
                        'default' => 'Ver cada frente em detalhe',
                    ],
                ],
            ],
            [
                'id' => 'stats',
                'label' => 'Seção "Por que pelo Instituto"',
                'fields' => [
                    [
                        'key' => 'home.stats.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Por que pelo Instituto',
                    ],
                    [
                        'key' => 'home.stats.title',
                        'label' => 'Título',
                        'default' => 'Mais rápido, mais prático e mais seguro',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.stat1.num',
                        'label' => 'Número 1',
                        'default' => '6',
                    ],
                    [
                        'key' => 'home.stat1.label',
                        'label' => 'Legenda 1',
                        'default' => 'instrumentos legais de contratação mapeados, cada um com a norma que o autoriza',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.stat2.num',
                        'label' => 'Número 2',
                        'default' => '6',
                    ],
                    [
                        'key' => 'home.stat2.label',
                        'label' => 'Legenda 2',
                        'default' => 'soluções no catálogo do Instituto, entre produtos de parceiros e serviços próprios',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.stat3.num',
                        'label' => 'Número 3',
                        'default' => 'R$ 0',
                    ],
                    [
                        'key' => 'home.stat3.label',
                        'label' => 'Legenda 3',
                        'default' => 'de custo para o diagnóstico técnico e o enquadramento jurídico',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.stat4.num',
                        'label' => 'Número 4',
                        'default' => '100%',
                    ],
                    [
                        'key' => 'home.stat4.label',
                        'label' => 'Legenda 4',
                        'default' => 'dos projetos com instrumento jurídico formalizado antes da execução',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.rite1.title',
                        'label' => 'Etapa 1 (faixa)',
                        'default' => 'Diagnóstico',
                    ],
                    [
                        'key' => 'home.rite1.sub',
                        'label' => 'Etapa 1 (faixa) — legenda',
                        'default' => 'sem custo',
                    ],
                    [
                        'key' => 'home.rite2.title',
                        'label' => 'Etapa 2 (faixa)',
                        'default' => 'Enquadramento',
                    ],
                    [
                        'key' => 'home.rite2.sub',
                        'label' => 'Etapa 2 (faixa) — legenda',
                        'default' => 'sem custo',
                    ],
                    [
                        'key' => 'home.rite3.title',
                        'label' => 'Etapa 3 (faixa)',
                        'default' => 'Formalização',
                    ],
                    [
                        'key' => 'home.rite3.sub',
                        'label' => 'Etapa 3 (faixa) — legenda',
                        'default' => 'o município conduz',
                    ],
                    [
                        'key' => 'home.rite4.title',
                        'label' => 'Etapa 4 (faixa)',
                        'default' => 'Implantação',
                    ],
                    [
                        'key' => 'home.rite4.sub',
                        'label' => 'Etapa 4 (faixa) — legenda',
                        'default' => 'metas e indicadores',
                    ],
                    [
                        'key' => 'home.rite5.title',
                        'label' => 'Etapa 5 (faixa)',
                        'default' => 'Operação',
                    ],
                    [
                        'key' => 'home.rite5.sub',
                        'label' => 'Etapa 5 (faixa) — legenda',
                        'default' => 'com prestação de contas',
                    ],
                    [
                        'key' => 'home.stats.copy1',
                        'label' => 'Parágrafo 1',
                        'default' => 'Mais rápido porque o diagnóstico técnico e a fundamentação jurídica chegam prontos à Procuradoria, em vez de serem construídos do zero dentro da prefeitura. Mais prático porque o município trata com um único interlocutor técnico, e não com um fornecedor para cada problema.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.stats.copy2',
                        'label' => 'Parágrafo 2',
                        'default' => 'Mais seguro não significa menos controle. Significa antecipá-lo. O gestor que contrata por aqui termina com mais documentação: diagnóstico técnico, fundamentação jurídica, plano de trabalho com indicadores, relatórios periódicos e prestação de contas publicada.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.stats.cta',
                        'label' => 'Botão',
                        'default' => 'Conheça a base legal',
                    ],
                ],
            ],
            [
                'id' => 'transp',
                'label' => 'Seção "Transparência"',
                'fields' => [
                    [
                        'key' => 'home.transp.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Transparência',
                    ],
                    [
                        'key' => 'home.transp.title',
                        'label' => 'Título',
                        'default' => 'Documentação pública e oficial',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.transp.text',
                        'label' => 'Texto',
                        'default' => 'Estatuto Social, atas registradas em cartório, regimento interno, CNPJ e termos de parceria. Caso queira acesso a toda a documentação, clique aqui.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.transp.cta',
                        'label' => 'Botão',
                        'default' => 'Solicitar documentos institucionais',
                    ],
                    [
                        'key' => 'home.transp.item1.title',
                        'label' => 'Cartão 1 — título',
                        'default' => 'Institucional',
                    ],
                    [
                        'key' => 'home.transp.item1.desc',
                        'label' => 'Cartão 1 — texto',
                        'default' => 'Estatuto, atas registradas, regimento e CNPJ',
                    ],
                    [
                        'key' => 'home.transp.item2.title',
                        'label' => 'Cartão 2 — título',
                        'default' => 'Normativos',
                    ],
                    [
                        'key' => 'home.transp.item2.desc',
                        'label' => 'Cartão 2 — texto',
                        'default' => 'Regulamentos, código de ética e políticas',
                    ],
                    [
                        'key' => 'home.transp.item3.title',
                        'label' => 'Cartão 3 — título',
                        'default' => 'Parcerias',
                    ],
                    [
                        'key' => 'home.transp.item3.desc',
                        'label' => 'Cartão 3 — texto',
                        'default' => 'Termos e acordos firmados pelo Instituto',
                    ],
                    [
                        'key' => 'home.transp.item4.title',
                        'label' => 'Cartão 4 — título',
                        'default' => 'Prestação de contas',
                    ],
                    [
                        'key' => 'home.transp.item4.desc',
                        'label' => 'Cartão 4 — texto',
                        'default' => 'Relatórios, demonstrativos e pareceres',
                    ],
                ],
            ],
            [
                'id' => 'finalcta',
                'label' => 'Chamada final',
                'fields' => [
                    [
                        'key' => 'home.finalcta.title',
                        'label' => 'Título',
                        'default' => 'Comece pelo diagnóstico, sem custo',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.finalcta.text',
                        'label' => 'Texto',
                        'default' => 'Conte qual é o problema do seu município. Medimos, apresentamos as alternativas e indicamos o caminho legal. Se o caso for de licitação comum, nós dizemos que é de licitação comum.',
                        'long' => true,
                    ],
                    [
                        'key' => 'home.finalcta.button',
                        'label' => 'Botão',
                        'default' => 'Falar com o Instituto',
                    ],
                ],
            ],
        ],
    ],
    [
        'page' => 'institucional',
        'pageLabel' => 'Institucional',
        'route' => 'institucional',
        'groups' => [
            [
                'id' => 'hero',
                'label' => 'Topo',
                'fields' => [
                    [
                        'key' => 'institucional.hero.eyebrow',
                        'label' => 'Selo',
                        'default' => 'Conheça o IDTNPR',
                    ],
                    [
                        'key' => 'institucional.hero.title',
                        'label' => 'Título',
                        'default' => 'Institucional',
                    ],
                    [
                        'key' => 'institucional.hero.lead',
                        'label' => 'Texto de apoio',
                        'default' => 'Quem somos, de onde viemos e como nos organizamos.',
                    ],
                ],
            ],
            [
                'id' => 'quemsomos',
                'label' => 'Seção "Quem somos"',
                'fields' => [
                    [
                        'key' => 'institucional.quemsomos.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Quem somos',
                    ],
                    [
                        'key' => 'institucional.quemsomos.title',
                        'label' => 'Título',
                        'default' => 'Uma instituição de ciência e tecnologia a serviço da gestão pública',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.quemsomos.sub',
                        'label' => 'Subtítulo',
                        'default' => 'O Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense (IDTNPR) é uma associação civil de direito privado, sem fins lucrativos, com sede em Sarandi, Paraná.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.quemsomos.p1',
                        'label' => 'Parágrafo 1',
                        'default' => 'Atuamos junto a prefeituras, câmaras municipais, consórcios públicos e demais entidades da Administração Pública, apoiando a modernização administrativa, a transformação digital e a estruturação de políticas de ciência, tecnologia e inovação.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.quemsomos.p2',
                        'label' => 'Parágrafo 2',
                        'default' => 'Nosso objeto social contempla a pesquisa aplicada de caráter tecnológico e o desenvolvimento de produtos, serviços e processos, o que nos enquadra como Instituição de Ciência e Tecnologia nos termos do art. 2º, inciso V, da Lei nº 10.973/2004, o Marco Legal de Ciência, Tecnologia e Inovação.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'identidade',
                'label' => 'Missão, visão e princípios',
                'fields' => [
                    [
                        'key' => 'institucional.missao.title',
                        'label' => 'Missão — título',
                        'default' => 'Missão',
                    ],
                    [
                        'key' => 'institucional.missao.text',
                        'label' => 'Missão — texto',
                        'default' => 'Fomentar o desenvolvimento tecnológico e a inovação em entidades públicas e privadas, com transparência, legalidade e compromisso com o interesse público.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.visao.title',
                        'label' => 'Visão — título',
                        'default' => 'Visão',
                    ],
                    [
                        'key' => 'institucional.visao.text',
                        'label' => 'Visão — texto',
                        'default' => 'Ser referência em inovação e tecnologia aplicada ao setor público, reconhecida pela excelência técnica e pelo impacto real na modernização da gestão pública.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.principios.title',
                        'label' => 'Princípios — título',
                        'default' => 'Princípios',
                    ],
                    [
                        'key' => 'institucional.principios.text',
                        'label' => 'Princípios — texto',
                        'default' => 'Legalidade · Impessoalidade · Moralidade · Publicidade · Eficiência · Transparência · Integridade institucional · Interesse público',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'historia',
                'label' => 'Seção "Nossa história"',
                'fields' => [
                    [
                        'key' => 'institucional.historia.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Nossa história',
                    ],
                    [
                        'key' => 'institucional.historia.title',
                        'label' => 'Título',
                        'default' => 'Como o Instituto chegou até aqui',
                    ],
                    [
                        'key' => 'institucional.historia.sub',
                        'label' => 'Subtítulo',
                        'default' => 'A história do IDTNPR começa com a escuta de gestores públicos e a percepção de um desafio comum: acompanhar o ritmo da tecnologia e da inovação no cotidiano da gestão.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.historia.p1',
                        'label' => 'Parágrafo 1',
                        'default' => 'Essas conversas foram o embrião de uma ideia. Pessoas com experiência no setor público, na tecnologia e na gestão começaram a discutir caminhos para mudar essa realidade e moldaram, a muitas mãos, o que o Instituto viria a ser.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.historia.p2',
                        'label' => 'Parágrafo 2',
                        'default' => 'Sarandi/PR foi escolhida como sede e ponto de partida para uma atuação que mira municípios, autarquias e entidades públicas de toda a região e do país. O que segue é o registro dos passos já dados.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.passo1.title',
                        'label' => 'Passo 1 — data',
                        'default' => 'Jul · 2025',
                    ],
                    [
                        'key' => 'institucional.passo1.text',
                        'label' => 'Passo 1 — texto',
                        'default' => 'Constituição do Instituto em assembleia de fundação, com aprovação do Estatuto Social e eleição da primeira Diretoria.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.passo2.title',
                        'label' => 'Passo 2 — data',
                        'default' => 'Set · 2025',
                    ],
                    [
                        'key' => 'institucional.passo2.text',
                        'label' => 'Passo 2 — texto',
                        'default' => 'Inscrição no Cadastro Nacional da Pessoa Jurídica, habilitando o Instituto a firmar instrumentos e operar formalmente.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.passo3.title',
                        'label' => 'Passo 3 — data',
                        'default' => 'Jan · 2026',
                    ],
                    [
                        'key' => 'institucional.passo3.text',
                        'label' => 'Passo 3 — texto',
                        'default' => 'Eleição da Diretoria Executiva e do Conselho Fiscal e Consultivo, com aprovação do Regimento Interno.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.passo4.title',
                        'label' => 'Passo 4 — data',
                        'default' => '2026',
                    ],
                    [
                        'key' => 'institucional.passo4.text',
                        'label' => 'Passo 4 — texto',
                        'default' => 'Primeira entrega técnica: elaboração de minuta para a Política Municipal de Ciência, Tecnologia e Inovação de Sarandi.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.passo5.title',
                        'label' => 'Passo 5 — data',
                        'default' => 'Ago · 2026',
                    ],
                    [
                        'key' => 'institucional.passo5.text',
                        'label' => 'Passo 5 — texto',
                        'default' => 'Primeira parceria com desenvolvedora, inaugurando a carteira de soluções tecnológicas do Instituto.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'governanca',
                'label' => 'Seção "Governança"',
                'fields' => [
                    [
                        'key' => 'institucional.governanca.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Governança',
                    ],
                    [
                        'key' => 'institucional.governanca.title',
                        'label' => 'Título',
                        'default' => 'Estrutura institucional',
                    ],
                    [
                        'key' => 'institucional.governanca.sub',
                        'label' => 'Subtítulo',
                        'default' => 'O IDTNPR é administrado por uma Diretoria Executiva e fiscalizado por um Conselho Fiscal e Consultivo, com sede em Sarandi, no Paraná.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.governanca.diretoria',
                        'label' => 'Título da Diretoria',
                        'default' => 'Diretoria Executiva',
                    ],
                    [
                        'key' => 'institucional.governanca.conselho',
                        'label' => 'Título do Conselho',
                        'default' => 'Conselho Fiscal e Consultivo',
                    ],
                ],
            ],
            [
                'id' => 'marcolegal',
                'label' => 'Seção "Marco legal"',
                'fields' => [
                    [
                        'key' => 'institucional.marcolegal.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Marco legal',
                    ],
                    [
                        'key' => 'institucional.marcolegal.title',
                        'label' => 'Título',
                        'default' => 'A base jurídica da nossa atuação',
                    ],
                    [
                        'key' => 'institucional.marcolegal.sub',
                        'label' => 'Subtítulo',
                        'default' => 'Toda cooperação entre o Instituto e uma entidade pública se apoia em norma expressa, e cada situação pede um instrumento diferente.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.marcolegal.btn',
                        'label' => 'Botão',
                        'default' => 'Ver o Marco Legal',
                    ],
                    [
                        'key' => 'institucional.marcolegal.card1.kicker',
                        'label' => 'Card 1 — selo',
                        'default' => 'Orientação',
                    ],
                    [
                        'key' => 'institucional.marcolegal.card1.title',
                        'label' => 'Card 1 — título',
                        'default' => 'Seis instrumentos',
                    ],
                    [
                        'key' => 'institucional.marcolegal.card1.text',
                        'label' => 'Card 1 — texto',
                        'default' => 'Um mapa de qual caminho legal se aplica a cada situação.',
                    ],
                    [
                        'key' => 'institucional.marcolegal.card2.kicker',
                        'label' => 'Card 2 — selo',
                        'default' => 'Documentação',
                    ],
                    [
                        'key' => 'institucional.marcolegal.card2.title',
                        'label' => 'Card 2 — título',
                        'default' => 'Minutas prontas',
                    ],
                    [
                        'key' => 'institucional.marcolegal.card2.text',
                        'label' => 'Card 2 — texto',
                        'default' => 'Instrumentos e checklists processuais para a Procuradoria.',
                    ],
                ],
            ],
            [
                'id' => 'cta',
                'label' => 'Chamada final',
                'fields' => [
                    [
                        'key' => 'institucional.cta.title',
                        'label' => 'Título',
                        'default' => 'Documentos institucionais',
                    ],
                    [
                        'key' => 'institucional.cta.text',
                        'label' => 'Texto',
                        'default' => 'Estatuto Social, atas registradas, regimento interno, normativos e prestação de contas.',
                        'long' => true,
                    ],
                    [
                        'key' => 'institucional.cta.btn',
                        'label' => 'Botão',
                        'default' => 'Portal da Transparência',
                    ],
                ],
            ],
        ],
    ],
    [
        'page' => 'atuacao',
        'pageLabel' => 'Atuação',
        'route' => 'atuacao',
        'groups' => [
            [
                'id' => 'hero',
                'label' => 'Topo',
                'banner' => 'assets/atuacao/hero.svg',
                'fields' => [
                    [
                        'key' => 'atuacao.hero.eyebrow',
                        'label' => 'Selo',
                        'default' => 'Soluções para a gestão pública',
                    ],
                    [
                        'key' => 'atuacao.hero.title',
                        'label' => 'Título',
                        'default' => 'Atuação',
                    ],
                    [
                        'key' => 'atuacao.hero.lead',
                        'label' => 'Texto de apoio',
                        'default' => 'O Instituto atua como hub de soluções para o poder público: reúne o que os parceiros desenvolvem, produz o que falta e entrega tudo pelo caminho legal adequado a cada caso.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.hero.cta',
                        'label' => 'Botão',
                        'default' => 'Solicitar diagnóstico gratuito',
                    ],
                ],
            ],
            [
                'id' => 'nav',
                'label' => 'Atalhos para as frentes',
                'fields' => [
                    [
                        'key' => 'atuacao.nav.governanca',
                        'label' => 'Atalho — Frente 01',
                        'default' => 'Governança',
                    ],
                    [
                        'key' => 'atuacao.nav.observatorio',
                        'label' => 'Atalho — Frente 02',
                        'default' => 'Observatório de dados',
                    ],
                    [
                        'key' => 'atuacao.nav.pmo',
                        'label' => 'Atalho — Frente 03',
                        'default' => 'PMO público',
                    ],
                    [
                        'key' => 'atuacao.nav.marcolegal',
                        'label' => 'Atalho — Frente 04',
                        'default' => 'Marco legal',
                    ],
                    [
                        'key' => 'atuacao.nav.capacitacao',
                        'label' => 'Atalho — Frente 05',
                        'default' => 'Capacitação',
                    ],
                    [
                        'key' => 'atuacao.nav.piloto',
                        'label' => 'Atalho — Frente 06',
                        'default' => 'Piloto e PD&I',
                    ],
                ],
            ],
            [
                'id' => 'governanca',
                'label' => 'Frente 01 — Governança e modernização',
                'banner' => 'assets/atuacao/governanca.svg',
                'fields' => [
                    [
                        'key' => 'atuacao.governanca.kicker',
                        'label' => 'Selo da seção',
                        'default' => '01 · Estruturação institucional',
                    ],
                    [
                        'key' => 'atuacao.governanca.title',
                        'label' => 'Título',
                        'default' => 'Governança e modernização da gestão pública',
                    ],
                    [
                        'key' => 'atuacao.governanca.sub',
                        'label' => 'Subtítulo',
                        'default' => 'Diagnóstico de maturidade administrativa, desenho de fluxos e processos, políticas internas, governança de dados e adequação à LGPD.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.governanca.text',
                        'label' => 'Texto',
                        'default' => 'Entregamos ao município a estrutura que ele precisa ter, e não o software que alguém quer vender. Em boa parte dos casos, o ganho de eficiência vem da revisão do processo antes de qualquer sistema entrar em operação.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.governanca.item1.title',
                        'label' => 'Item 1 — destaque',
                        'default' => 'Diagnóstico de maturidade digital e administrativa',
                    ],
                    [
                        'key' => 'atuacao.governanca.item1.text',
                        'label' => 'Item 1 — complemento',
                        'default' => 'com indicadores comparáveis.',
                    ],
                    [
                        'key' => 'atuacao.governanca.item2.title',
                        'label' => 'Item 2 — destaque',
                        'default' => 'Mapeamento e redesenho de processos',
                    ],
                    [
                        'key' => 'atuacao.governanca.item2.text',
                        'label' => 'Item 2 — complemento',
                        'default' => 'nas áreas mais críticas.',
                    ],
                    [
                        'key' => 'atuacao.governanca.item3.title',
                        'label' => 'Item 3 — destaque',
                        'default' => 'Políticas internas',
                    ],
                    [
                        'key' => 'atuacao.governanca.item3.text',
                        'label' => 'Item 3 — complemento',
                        'default' => 'de segurança da informação, uso de dados e governança de TI.',
                    ],
                    [
                        'key' => 'atuacao.governanca.item4.title',
                        'label' => 'Item 4 — destaque',
                        'default' => 'Adequação à LGPD',
                    ],
                    [
                        'key' => 'atuacao.governanca.item4.text',
                        'label' => 'Item 4 — complemento',
                        'default' => ': inventário de dados, bases legais, encarregado e relatório de impacto.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'observatorio',
                'label' => 'Frente 02 — Observatório de dados',
                'banner' => 'assets/atuacao/observatorio.svg',
                'fields' => [
                    [
                        'key' => 'atuacao.observatorio.kicker',
                        'label' => 'Selo da seção',
                        'default' => '02 · Gestão por evidências',
                    ],
                    [
                        'key' => 'atuacao.observatorio.title',
                        'label' => 'Título',
                        'default' => 'Observatório de dados e inteligência municipal',
                    ],
                    [
                        'key' => 'atuacao.observatorio.sub',
                        'label' => 'Subtítulo',
                        'default' => 'Painéis de indicadores, integração de bases públicas e leitura analítica para decisão.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.observatorio.text',
                        'label' => 'Texto',
                        'default' => 'O gestor passa a decidir com número e o cidadão passa a enxergar o resultado. Municípios pequenos já produzem muito dado. O que falta é reuni-lo, cruzá-lo e transformá-lo em informação de gestão.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.observatorio.item1.title',
                        'label' => 'Item 1 — destaque',
                        'default' => 'Painéis de indicadores',
                    ],
                    [
                        'key' => 'atuacao.observatorio.item1.text',
                        'label' => 'Item 1 — complemento',
                        'default' => 'por secretaria, com atualização automatizada.',
                    ],
                    [
                        'key' => 'atuacao.observatorio.item2.title',
                        'label' => 'Item 2 — destaque',
                        'default' => 'Integração de bases públicas',
                    ],
                    [
                        'key' => 'atuacao.observatorio.item2.text',
                        'label' => 'Item 2 — complemento',
                        'default' => 'municipais, estaduais e federais.',
                    ],
                    [
                        'key' => 'atuacao.observatorio.item3.title',
                        'label' => 'Item 3 — destaque',
                        'default' => 'Relatórios analíticos periódicos',
                    ],
                    [
                        'key' => 'atuacao.observatorio.item3.text',
                        'label' => 'Item 3 — complemento',
                        'default' => 'com leitura técnica, não apenas gráficos.',
                    ],
                    [
                        'key' => 'atuacao.observatorio.item4.title',
                        'label' => 'Item 4 — destaque',
                        'default' => 'Painel público de transparência',
                    ],
                    [
                        'key' => 'atuacao.observatorio.item4.text',
                        'label' => 'Item 4 — complemento',
                        'default' => 'para o cidadão acompanhar.',
                    ],
                ],
            ],
            [
                'id' => 'pmo',
                'label' => 'Frente 03 — PMO público',
                'banner' => 'assets/atuacao/pmo.svg',
                'fields' => [
                    [
                        'key' => 'atuacao.pmo.kicker',
                        'label' => 'Selo da seção',
                        'default' => '03 · Capacidade de execução',
                    ],
                    [
                        'key' => 'atuacao.pmo.title',
                        'label' => 'Título',
                        'default' => 'PMO público e gestão de projetos',
                    ],
                    [
                        'key' => 'atuacao.pmo.sub',
                        'label' => 'Subtítulo',
                        'default' => 'Escritório de projetos para a prefeitura: priorização de portfólio, plano de trabalho, cronograma, indicadores e apoio técnico ao fiscal de contrato.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.pmo.question',
                        'label' => 'Pergunta em destaque',
                        'default' => 'Apoio técnico para transformar planejamento em entrega.',
                    ],
                    [
                        'key' => 'atuacao.pmo.answer',
                        'label' => 'Resposta — início',
                        'default' => 'O fiscal do contrato é sempre agente público designado por portaria, e essa titularidade é indelegável. Fornecemos o corpo técnico, os relatórios e os indicadores que ele não tem como produzir internamente, na forma autorizada pelo art. 117,',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.pmo.answer.highlight',
                        'label' => 'Resposta — trecho em itálico',
                        'default' => 'caput',
                    ],
                    [
                        'key' => 'atuacao.pmo.answer.end',
                        'label' => 'Resposta — final',
                        'default' => ', da Lei nº 14.133/2021.',
                    ],
                    [
                        'key' => 'atuacao.pmo.note.title',
                        'label' => 'Nota — título',
                        'default' => 'Atuação independente',
                    ],
                    [
                        'key' => 'atuacao.pmo.note.text',
                        'label' => 'Nota — texto',
                        'default' => 'Essa frente também se aplica a contratos que não são nossos. Podemos apoiar tecnicamente a fiscalização de contratos de qualquer fornecedor. Quando há parceiro do Instituto naquele contrato, não atuamos nessa função.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'marcolegal',
                'label' => 'Frente 04 — Marco legal de inovação',
                'banner' => 'assets/atuacao/marcolegal.svg',
                'fields' => [
                    [
                        'key' => 'atuacao.marcolegal.kicker',
                        'label' => 'Selo da seção',
                        'default' => '04 · Política pública estruturante',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.title',
                        'label' => 'Título',
                        'default' => 'Marco legal de inovação municipal',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.sub',
                        'label' => 'Subtítulo',
                        'default' => 'Elaboração da Lei Municipal de Ciência, Tecnologia e Inovação, do decreto de regulamentação, do regimento do Conselho Municipal e do desenho do Fundo Municipal de Inovação.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.marcolegal.text',
                        'label' => 'Texto',
                        'default' => 'Com base na Lei nº 10.973/2004, na Lei Complementar nº 182/2021 e na Lei Estadual/PR nº 20.541/2021. Municípios com política de CT&I institucionalizada acessam mecanismos estaduais de fomento, inclusive o repasse fundo a fundo previsto na Lei Estadual/PR nº 22.107/2024.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.marcolegal.item1.title',
                        'label' => 'Item 1 — destaque',
                        'default' => 'Minuta de Lei Municipal de CT&I',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.item1.text',
                        'label' => 'Item 1 — complemento',
                        'default' => 'com exposição de motivos.',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.item2.title',
                        'label' => 'Item 2 — destaque',
                        'default' => 'Decreto de regulamentação',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.item2.text',
                        'label' => 'Item 2 — complemento',
                        'default' => 'e Programa de Aplicações Piloto.',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.item3.title',
                        'label' => 'Item 3 — destaque',
                        'default' => 'Conselho Municipal de Inovação',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.item3.text',
                        'label' => 'Item 3 — complemento',
                        'default' => ': composição, regimento e instalação.',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.item4.title',
                        'label' => 'Item 4 — destaque',
                        'default' => 'Fundo Municipal de Inovação',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.item4.text',
                        'label' => 'Item 4 — complemento',
                        'default' => ': desenho, fontes e regras de aplicação.',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.note.start',
                        'label' => 'Observação — início',
                        'default' => 'As leis que redigimos são',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.note.highlight',
                        'label' => 'Observação — trecho em negrito',
                        'default' => 'normas gerais e abertas',
                    ],
                    [
                        'key' => 'atuacao.marcolegal.note.end',
                        'label' => 'Observação — final',
                        'default' => ': criam procedimento, não escolhem fornecedor nem definem especificação técnica que favoreça qualquer solução.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'capacitacao',
                'label' => 'Frente 05 — Capacitação de servidores',
                'banner' => 'assets/atuacao/capacitacao.svg',
                'fields' => [
                    [
                        'key' => 'atuacao.capacitacao.kicker',
                        'label' => 'Selo da seção',
                        'default' => '05 · Formação continuada',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.title',
                        'label' => 'Título',
                        'default' => 'Capacitação de servidores',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.sub',
                        'label' => 'Subtítulo',
                        'default' => 'Trilhas curtas e aplicadas, presenciais ou remotas, com certificação e material próprio.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card1.title',
                        'label' => 'Trilha 1 — título',
                        'default' => 'Nova Lei de Licitações',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card1.text',
                        'label' => 'Trilha 1 — texto',
                        'default' => 'Lei nº 14.133/2021 aplicada à realidade do município pequeno.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card2.title',
                        'label' => 'Trilha 2 — título',
                        'default' => 'LGPD aplicada',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card2.text',
                        'label' => 'Trilha 2 — texto',
                        'default' => 'Bases legais, tratamento, incidentes e direitos do titular.',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card3.title',
                        'label' => 'Trilha 3 — título',
                        'default' => 'Governo digital',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card3.text',
                        'label' => 'Trilha 3 — texto',
                        'default' => 'Lei nº 14.129/2021 e digitalização de serviços.',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card4.title',
                        'label' => 'Trilha 4 — título',
                        'default' => 'Segurança da informação',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card4.text',
                        'label' => 'Trilha 4 — texto',
                        'default' => 'Práticas essenciais para servidores e gestores.',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card5.title',
                        'label' => 'Trilha 5 — título',
                        'default' => 'Rotinas tributárias e contábeis',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card5.text',
                        'label' => 'Trilha 5 — texto',
                        'default' => 'Escrituração, obrigações acessórias e prazos do Tribunal de Contas.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card6.title',
                        'label' => 'Trilha 6 — título',
                        'default' => 'Marco Legal de CT&I',
                    ],
                    [
                        'key' => 'atuacao.capacitacao.card6.text',
                        'label' => 'Trilha 6 — texto',
                        'default' => 'Instrumentos de inovação disponíveis ao município.',
                    ],
                ],
            ],
            [
                'id' => 'piloto',
                'label' => 'Frente 06 — Aplicações piloto',
                'banner' => 'assets/atuacao/piloto.svg',
                'fields' => [
                    [
                        'key' => 'atuacao.piloto.kicker',
                        'label' => 'Selo da seção',
                        'default' => '06 · Testar antes de comprar',
                    ],
                    [
                        'key' => 'atuacao.piloto.title',
                        'label' => 'Título',
                        'default' => 'Aplicações piloto e PD&I',
                    ],
                    [
                        'key' => 'atuacao.piloto.sub',
                        'label' => 'Subtítulo',
                        'default' => 'Estruturação de aplicações piloto e ambientes de teste com rito formal.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.piloto.text',
                        'label' => 'Texto',
                        'default' => 'Chamamento público aberto a qualquer interessado, acordo de parceria para pesquisa e desenvolvimento, e relatório técnico público ao final, inclusive com os resultados negativos e as limitações encontradas. O município conhece a solução antes de decidir, e a decisão fica documentada.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.piloto.note.title',
                        'label' => 'Nota — título',
                        'default' => 'Sem preferência de contratação',
                    ],
                    [
                        'key' => 'atuacao.piloto.note.highlight',
                        'label' => 'Nota — frase em destaque',
                        'default' => 'O piloto não gera direito de contratação.',
                    ],
                    [
                        'key' => 'atuacao.piloto.note.text',
                        'label' => 'Nota — texto',
                        'default' => 'Todos os nossos instrumentos de aplicação piloto contêm cláusula expressa de que a execução não gera preferência, expectativa de direito ou obrigação de contratar em procedimento futuro.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'cta',
                'label' => 'Chamada final',
                'fields' => [
                    [
                        'key' => 'atuacao.cta.title',
                        'label' => 'Título',
                        'default' => 'Qual é o problema do seu município?',
                    ],
                    [
                        'key' => 'atuacao.cta.text',
                        'label' => 'Texto',
                        'default' => 'O diagnóstico é gratuito. Medimos o problema, apresentamos as alternativas e indicamos o instrumento jurídico aplicável ao caso.',
                        'long' => true,
                    ],
                    [
                        'key' => 'atuacao.cta.btn',
                        'label' => 'Botão',
                        'default' => 'Solicitar diagnóstico',
                    ],
                ],
            ],
        ],
    ],
    [
        'page' => 'marcolegal',
        'pageLabel' => 'Marco Legal',
        'route' => 'marco-legal',
        'groups' => [
            [
                'id' => 'hero',
                'label' => 'Topo',
                'fields' => [
                    [
                        'key' => 'marcolegal.hero.title',
                        'label' => 'Título',
                        'default' => 'A base legal da nossa atuação',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.hero.lead',
                        'label' => 'Texto de apoio',
                        'default' => 'Atuamos com fundamento em normas nacionais que alcançam diretamente os Municípios, independentemente de legislação local.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'normas',
                'label' => 'Seção "As normas que sustentam a cooperação"',
                'fields' => [
                    [
                        'key' => 'marcolegal.normas.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Fundamentação',
                    ],
                    [
                        'key' => 'marcolegal.normas.title',
                        'label' => 'Título',
                        'default' => 'As normas que sustentam a cooperação',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.norma1.ref',
                        'label' => 'Norma 1 — referência',
                        'default' => 'Constituição Federal, art. 219-A',
                    ],
                    [
                        'key' => 'marcolegal.norma1.desc',
                        'label' => 'Norma 1 — descrição',
                        'default' => 'Autoriza cooperação entre entes federativos e entidades públicas/privadas para pesquisa, desenvolvimento e inovação.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.norma2.ref',
                        'label' => 'Norma 2 — referência',
                        'default' => 'Lei nº 10.973/2004 (Marco Legal de CT&I)',
                    ],
                    [
                        'key' => 'marcolegal.norma2.desc',
                        'label' => 'Norma 2 — descrição',
                        'default' => 'Define ICT privada, acordos de parceria e encomenda tecnológica.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.norma3.ref',
                        'label' => 'Norma 3 — referência',
                        'default' => 'Lei Complementar nº 182/2021 (Marco Legal das Startups)',
                    ],
                    [
                        'key' => 'marcolegal.norma3.desc',
                        'label' => 'Norma 3 — descrição',
                        'default' => 'Institui o Contrato Público para Solução Inovadora, aplicável a todos os entes federativos.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.norma4.ref',
                        'label' => 'Norma 4 — referência',
                        'default' => 'Lei nº 14.133/2021',
                    ],
                    [
                        'key' => 'marcolegal.norma4.desc',
                        'label' => 'Norma 4 — descrição',
                        'default' => 'Dispensa, inexigibilidade e apoio técnico em contratações.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.norma5.ref',
                        'label' => 'Norma 5 — referência',
                        'default' => 'Lei nº 13.019/2014 (MROSC)',
                    ],
                    [
                        'key' => 'marcolegal.norma5.desc',
                        'label' => 'Norma 5 — descrição',
                        'default' => 'Termos de fomento e colaboração com a sociedade civil.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.norma6.ref',
                        'label' => 'Norma 6 — referência',
                        'default' => 'Lei nº 14.129/2021',
                    ],
                    [
                        'key' => 'marcolegal.norma6.desc',
                        'label' => 'Norma 6 — descrição',
                        'default' => 'Governo Digital.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.norma7.ref',
                        'label' => 'Norma 7 — referência',
                        'default' => 'Lei Estadual/PR nº 20.541/2021',
                    ],
                    [
                        'key' => 'marcolegal.norma7.desc',
                        'label' => 'Norma 7 — descrição',
                        'default' => 'Política de Inovação do Paraná.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.norma8.ref',
                        'label' => 'Norma 8 — referência',
                        'default' => 'Lei Estadual/PR nº 22.107/2024',
                    ],
                    [
                        'key' => 'marcolegal.norma8.desc',
                        'label' => 'Norma 8 — descrição',
                        'default' => 'Fomento fundo a fundo aos municípios paranaenses.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'ict',
                'label' => 'Seção "É uma ICT?"',
                'fields' => [
                    [
                        'key' => 'marcolegal.ict.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Instituição de Ciência e Tecnologia',
                    ],
                    [
                        'key' => 'marcolegal.ict.question',
                        'label' => 'Pergunta',
                        'default' => 'O IDTNPR é uma ICT?',
                    ],
                    [
                        'key' => 'marcolegal.ict.answer',
                        'label' => 'Resposta',
                        'default' => 'Sim. ICT não é certificado governamental, mas enquadramento legal conforme art. 2º, inciso V, da Lei nº 10.973/2004.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.ict.def.title',
                        'label' => 'Título da definição',
                        'default' => 'O que diz a lei',
                    ],
                    [
                        'key' => 'marcolegal.ict.def.text',
                        'label' => 'Texto da definição',
                        'default' => 'ICT é órgão ou entidade da administração pública ou pessoa jurídica de direito privado sem fins lucrativos, constituída sob as leis brasileiras, com sede no País, que inclua em sua missão institucional a pesquisa científica e tecnológica ou o desenvolvimento de produtos, serviços ou processos.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.ict.req.title',
                        'label' => 'Título dos requisitos',
                        'default' => 'Requisitos que o IDTNPR atende',
                    ],
                    [
                        'key' => 'marcolegal.ict.req1',
                        'label' => 'Requisito 1',
                        'default' => 'Pessoa jurídica de direito privado sem fins lucrativos',
                    ],
                    [
                        'key' => 'marcolegal.ict.req2',
                        'label' => 'Requisito 2',
                        'default' => 'Constituída sob leis brasileiras',
                    ],
                    [
                        'key' => 'marcolegal.ict.req3',
                        'label' => 'Requisito 3',
                        'default' => 'Sede e foro em Sarandi/PR',
                    ],
                    [
                        'key' => 'marcolegal.ict.req4',
                        'label' => 'Requisito 4',
                        'default' => 'Objeto social inclui pesquisa aplicada tecnológica e desenvolvimento',
                    ],
                    [
                        'key' => 'marcolegal.ict.verif.title',
                        'label' => 'Título da verificação',
                        'default' => 'Quem verifica isso?',
                    ],
                    [
                        'key' => 'marcolegal.ict.verif.text',
                        'label' => 'Texto da verificação',
                        'default' => 'A própria entidade contratante. Ao analisar uma cooperação, a Procuradoria do Município confronta o objeto social constante do Estatuto Social registrado com a definição legal.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'mapa',
                'label' => 'Seção "Seis instrumentos, seis situações" (tabela)',
                'fields' => [
                    [
                        'key' => 'marcolegal.mapa.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'O mapa',
                    ],
                    [
                        'key' => 'marcolegal.mapa.title',
                        'label' => 'Título',
                        'default' => 'Seis instrumentos, seis situações',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.intro',
                        'label' => 'Texto introdutório',
                        'default' => 'Cada caso pede um instrumento diferente. Parte do nosso trabalho é identificar qual se aplica, e dizer com clareza quando nenhum se aplica.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.col1',
                        'label' => 'Cabeçalho da coluna 1',
                        'default' => 'Situação',
                    ],
                    [
                        'key' => 'marcolegal.mapa.col2',
                        'label' => 'Cabeçalho da coluna 2',
                        'default' => 'Instrumento',
                    ],
                    [
                        'key' => 'marcolegal.mapa.col3',
                        'label' => 'Cabeçalho da coluna 3',
                        'default' => 'Fundamento',
                    ],
                    [
                        'key' => 'marcolegal.mapa.row1.situacao',
                        'label' => 'Linha 1 — situação',
                        'default' => 'Problema definido, solução não existe pronta, há risco tecnológico',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row1.instrumento',
                        'label' => 'Linha 1 — instrumento',
                        'default' => 'Encomenda tecnológica',
                    ],
                    [
                        'key' => 'marcolegal.mapa.row1.fundamento',
                        'label' => 'Linha 1 — fundamento',
                        'default' => 'Lei nº 10.973/2004, art. 20 + Lei nº 14.133/2021, art. 75, V',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row2.situacao',
                        'label' => 'Linha 2 — situação',
                        'default' => 'Problema conhecido, solução em aberto',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row2.instrumento',
                        'label' => 'Linha 2 — instrumento',
                        'default' => 'CPSI',
                    ],
                    [
                        'key' => 'marcolegal.mapa.row2.fundamento',
                        'label' => 'Linha 2 — fundamento',
                        'default' => 'LC nº 182/2021, arts. 12 a 15',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row3.situacao',
                        'label' => 'Linha 3 — situação',
                        'default' => 'Serviço técnico especializado de natureza singular',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row3.instrumento',
                        'label' => 'Linha 3 — instrumento',
                        'default' => 'Inexigibilidade',
                    ],
                    [
                        'key' => 'marcolegal.mapa.row3.fundamento',
                        'label' => 'Linha 3 — fundamento',
                        'default' => 'Lei nº 14.133/2021, art. 74, III',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row4.situacao',
                        'label' => 'Linha 4 — situação',
                        'default' => 'Capacitação e treinamento de servidores',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row4.instrumento',
                        'label' => 'Linha 4 — instrumento',
                        'default' => 'Inexigibilidade',
                    ],
                    [
                        'key' => 'marcolegal.mapa.row4.fundamento',
                        'label' => 'Linha 4 — fundamento',
                        'default' => 'Lei nº 14.133/2021, art. 74, III, "f"',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row5.situacao',
                        'label' => 'Linha 5 — situação',
                        'default' => 'Atividade de interesse público em regime de mútua cooperação',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row5.instrumento',
                        'label' => 'Linha 5 — instrumento',
                        'default' => 'Termo de fomento ou de colaboração',
                    ],
                    [
                        'key' => 'marcolegal.mapa.row5.fundamento',
                        'label' => 'Linha 5 — fundamento',
                        'default' => 'Lei nº 13.019/2014',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row6.situacao',
                        'label' => 'Linha 6 — situação',
                        'default' => 'Gestão de programa ou política pública',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.row6.instrumento',
                        'label' => 'Linha 6 — instrumento',
                        'default' => 'Contrato de gestão',
                    ],
                    [
                        'key' => 'marcolegal.mapa.row6.fundamento',
                        'label' => 'Linha 6 — fundamento',
                        'default' => 'Lei nº 9.637/1998 e STF, ADI 1923/DF',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.mapa.none.title',
                        'label' => 'Título "Quando nenhum se aplica"',
                        'default' => 'Quando nenhum instrumento se aplica',
                    ],
                    [
                        'key' => 'marcolegal.mapa.none.text',
                        'label' => 'Texto "Quando nenhum se aplica"',
                        'default' => 'Quando a solução é madura e há vários fornecedores no mercado, o caminho é a licitação comum, e nós dizemos isso com todas as letras. Recomendar licitação quando é o caso é o que dá credibilidade às vezes em que a contratação direta realmente se justifica.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'procuradorias',
                'label' => 'Seção "Para Procuradorias Municipais"',
                'fields' => [
                    [
                        'key' => 'marcolegal.proc.kicker',
                        'label' => 'Selo da seção',
                        'default' => 'Para Procuradorias Municipais',
                    ],
                    [
                        'key' => 'marcolegal.proc.title',
                        'label' => 'Título',
                        'default' => 'Material jurídico sob solicitação',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.proc.text1',
                        'label' => 'Parágrafo 1',
                        'default' => 'A assessoria jurídica do Município pode pedir, sem custo, o material de fundamentação referente ao instrumento que estiver analisando: minutas, notas de fundamentação e o rito processual da modalidade.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.proc.text2',
                        'label' => 'Parágrafo 2',
                        'default' => 'Basta dizer qual é o caso concreto e o que precisa. Respondemos com o que for aplicável àquela situação específica.',
                        'long' => true,
                    ],
                    [
                        'key' => 'marcolegal.proc.cta1',
                        'label' => 'Botão — WhatsApp',
                        'default' => 'Solicitar pelo WhatsApp',
                    ],
                    [
                        'key' => 'marcolegal.proc.cta2',
                        'label' => 'Botão — e-mail',
                        'default' => 'Solicitar por e-mail',
                    ],
                    [
                        'key' => 'marcolegal.proc.disclaimer',
                        'label' => 'Ressalva legal',
                        'default' => 'O envio do material não cria vínculo, obrigação de contratar nem expectativa de direito de qualquer natureza, e a análise permanece integralmente a cargo da Procuradoria do Município.',
                        'long' => true,
                    ],
                ],
            ],
        ],
    ],
    [
        'page' => 'contato',
        'pageLabel' => 'Contato',
        'route' => 'contato',
        'groups' => [
            [
                'id' => 'hero',
                'label' => 'Topo da página',
                'fields' => [
                    [
                        'key' => 'contato.hero.title',
                        'label' => 'Título',
                        'default' => 'Fale com o Instituto',
                    ],
                    [
                        'key' => 'contato.hero.lead',
                        'label' => 'Texto de apoio',
                        'default' => 'Conte qual é o problema do seu município. O diagnóstico inicial é gratuito.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'institucional',
                'label' => 'Blocos de contato institucional',
                'fields' => [
                    [
                        'key' => 'contato.institucional.card1.title',
                        'label' => 'Título — bloco 1',
                        'default' => 'Contato institucional',
                    ],
                    [
                        'key' => 'contato.institucional.card2.title',
                        'label' => 'Título — bloco 2',
                        'default' => 'Endereço',
                    ],
                    [
                        'key' => 'contato.institucional.card3.title',
                        'label' => 'Título — bloco 3',
                        'default' => 'Identificação',
                    ],
                    [
                        'key' => 'contato.institucional.razao_social',
                        'label' => 'Razão social',
                        'default' => 'Instituto de Desenvolvimento de Tecnologias do Noroeste Paranaense',
                    ],
                    [
                        'key' => 'contato.institucional.natureza',
                        'label' => 'Natureza jurídica',
                        'default' => 'Associação privada sem fins lucrativos',
                    ],
                ],
            ],
            [
                'id' => 'diagnostico',
                'label' => 'Formulário — diagnóstico gratuito',
                'fields' => [
                    [
                        'key' => 'contato.diagnostico.kicker',
                        'label' => 'Selo',
                        'default' => 'Para gestores públicos',
                    ],
                    [
                        'key' => 'contato.diagnostico.title',
                        'label' => 'Título',
                        'default' => 'Solicite o diagnóstico gratuito',
                    ],
                    [
                        'key' => 'contato.diagnostico.text1',
                        'label' => 'Parágrafo 1',
                        'default' => 'Conte qual é o problema: fila no atendimento, dificuldade de integrar sistemas, falta de indicadores, manutenção de equipamentos, o que for.',
                        'long' => true,
                    ],
                    [
                        'key' => 'contato.diagnostico.text2',
                        'label' => 'Parágrafo 2',
                        'default' => 'Retornamos com uma proposta de diagnóstico: o que vamos medir, em quanto tempo e o que o município recebe ao final. Sem custo e sem compromisso de contratação.',
                        'long' => true,
                    ],
                    [
                        'key' => 'contato.diagnostico.aud1.title',
                        'label' => 'Público 1 — título',
                        'default' => 'Prefeituras e secretarias',
                    ],
                    [
                        'key' => 'contato.diagnostico.aud1.text',
                        'label' => 'Público 1 — texto',
                        'default' => 'Diagnóstico do problema, alternativas de mercado, estimativa de custo e indicação do instrumento jurídico aplicável.',
                        'long' => true,
                    ],
                    [
                        'key' => 'contato.diagnostico.aud2.title',
                        'label' => 'Público 2 — título',
                        'default' => 'Procuradorias municipais',
                    ],
                    [
                        'key' => 'contato.diagnostico.aud2.text',
                        'label' => 'Público 2 — texto',
                        'default' => 'Minutas, notas de fundamentação e checklists processuais, sem custo e sem vínculo.',
                        'long' => true,
                    ],
                    [
                        'key' => 'contato.diagnostico.aud2.link',
                        'label' => 'Público 2 — link para o Marco Legal',
                        'default' => 'Ver o material disponível',
                    ],
                    [
                        'key' => 'contato.diagnostico.aud3.title',
                        'label' => 'Público 3 — título',
                        'default' => 'Empresas de tecnologia',
                    ],
                    [
                        'key' => 'contato.diagnostico.aud3.text',
                        'label' => 'Público 3 — texto',
                        'default' => 'Interesse em integrar a carteira de soluções do Instituto? Nossos processos de credenciamento são abertos e não excludentes.',
                        'long' => true,
                    ],
                    [
                        'key' => 'contato.form.btn_whatsapp',
                        'label' => 'Botão — enviar pelo WhatsApp',
                        'default' => 'Enviar pelo WhatsApp',
                    ],
                    [
                        'key' => 'contato.form.btn_email',
                        'label' => 'Botão — enviar por e-mail',
                        'default' => 'Enviar por e-mail',
                    ],
                    [
                        'key' => 'contato.form.note',
                        'label' => 'Ressalva abaixo do formulário',
                        'default' => 'Os dados preenchidos não são armazenados neste site: ao clicar, a mensagem é montada e aberta no seu WhatsApp ou no seu programa de e-mail, e só é enviada por você.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'ouvidoria',
                'label' => 'Ouvidoria',
                'fields' => [
                    [
                        'key' => 'contato.ouvidoria.kicker',
                        'label' => 'Selo',
                        'default' => 'Canal de integridade',
                    ],
                    [
                        'key' => 'contato.ouvidoria.title',
                        'label' => 'Título',
                        'default' => 'Ouvidoria',
                    ],
                    [
                        'key' => 'contato.ouvidoria.text1',
                        'label' => 'Parágrafo 1',
                        'default' => 'Canal para denúncias, reclamações, sugestões e pedidos de informação sobre a atuação do IDTNPR.',
                        'long' => true,
                    ],
                    [
                        'key' => 'contato.ouvidoria.text2',
                        'label' => 'Parágrafo 2',
                        'default' => 'As manifestações podem ser identificadas ou anônimas e são respondidas em até 20 dias úteis. Manifestações sobre conduta de dirigentes são encaminhadas diretamente ao Conselho Fiscal e Consultivo.',
                        'long' => true,
                    ],
                    [
                        'key' => 'contato.ouvidoria.tag',
                        'label' => 'Selo do quadro de destaque',
                        'default' => 'Ouvidoria',
                    ],
                    [
                        'key' => 'contato.ouvidoria.note',
                        'label' => 'Ressalva do quadro de destaque',
                        'default' => 'É vedada qualquer forma de retaliação contra quem apresenta manifestação de boa-fé.',
                        'long' => true,
                    ],
                ],
            ],
        ],
    ],
    [
        'page' => 'transparencia',
        'pageLabel' => 'Transparência',
        'route' => 'transparencia',
        'groups' => [
            [
                'id' => 'hero',
                'label' => 'Topo da página',
                'fields' => [
                    [
                        'key' => 'transparencia.hero.title',
                        'label' => 'Título',
                        'default' => 'Portal da Transparência',
                    ],
                    [
                        'key' => 'transparencia.hero.lead',
                        'label' => 'Texto de apoio',
                        'default' => 'Os atos institucionais do Instituto são registrados em cartório e ficam à disposição de qualquer pessoa. Solicite o documento que precisa e enviamos o arquivo.',
                        'long' => true,
                    ],
                ],
            ],
            [
                'id' => 'cta',
                'label' => 'Chamada — solicitar documento',
                'fields' => [
                    [
                        'key' => 'transparencia.cta.title',
                        'label' => 'Título',
                        'default' => 'Precisa de algum documento?',
                    ],
                    [
                        'key' => 'transparencia.cta.text',
                        'label' => 'Texto',
                        'default' => 'Estatuto Social, atas registradas, regimento interno, CNPJ, termos de parceria. Todos existem, estão registrados e podem ser enviados a você. Diga qual precisa e respondemos com o arquivo.',
                        'long' => true,
                    ],
                    [
                        'key' => 'transparencia.cta.btn_whatsapp',
                        'label' => 'Botão — WhatsApp',
                        'default' => 'Solicitar pelo WhatsApp',
                    ],
                    [
                        'key' => 'transparencia.cta.btn_email',
                        'label' => 'Botão — e-mail',
                        'default' => 'Solicitar por e-mail',
                    ],
                ],
            ],
            [
                'id' => 'editais',
                'label' => 'Aviso — editais e chamamentos',
                'fields' => [
                    [
                        'key' => 'transparencia.editais.title',
                        'label' => 'Título',
                        'default' => 'Editais e chamamentos',
                    ],
                    [
                        'key' => 'transparencia.editais.text',
                        'label' => 'Texto',
                        'default' => 'Os processos de credenciamento e chamamento público do Instituto ficam reunidos em página própria, com o edital completo, os prazos e o canal de inscrição.',
                        'long' => true,
                    ],
                    [
                        'key' => 'transparencia.editais.btn',
                        'label' => 'Botão',
                        'default' => 'Ver editais e chamamentos',
                    ],
                ],
            ],
            [
                'id' => 'pedidos',
                'label' => 'Pedidos de informação',
                'fields' => [
                    [
                        'key' => 'transparencia.pedidos.kicker',
                        'label' => 'Selo',
                        'default' => 'Acesso à informação',
                    ],
                    [
                        'key' => 'transparencia.pedidos.title',
                        'label' => 'Título',
                        'default' => 'Pedidos de informação',
                    ],
                    [
                        'key' => 'transparencia.pedidos.text',
                        'label' => 'Texto (antes dos links de e-mail e Ouvidoria)',
                        'default' => 'Qualquer pessoa pode solicitar informações sobre a atuação do Instituto, identificando-se ou não, pelo e-mail',
                        'long' => true,
                    ],
                ],
            ],
        ],
    ],
];
