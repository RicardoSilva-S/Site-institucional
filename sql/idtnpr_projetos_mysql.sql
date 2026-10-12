-- =====================================================================
-- IDTNPR - Tabelas da página Projetos (MySQL)
--
-- Origem: "Tabela de Projetos", passada pelo professor.
--   Projetos            -> título, breve descrição, categorias, estágio, problema
--   Descricao_projetos  -> IdProjeto, título, texto
--
-- Um projeto tem vários blocos de descrição (cada bloco é um título + um
-- texto, como o "O que o Acquora faz" do site atual). Relação 1 : N.
--
-- Decisões:
--   - Nomes em snake_case e sem acento, no padrão das outras tabelas do
--     projeto. "IdProjeto" virou projeto_id, igual a secao_id em
--     transparencia_documentos.
--   - created_at e updated_at seguem o padrão do Laravel, para o projeto
--     poder usar estas tabelas sem ajuste.
--   - Só estrutura: não insere dados.
--   - O script não escolhe banco (sem CREATE DATABASE nem USE): ele cria as
--     tabelas no banco que estiver selecionado na conexão.
-- =====================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- projetos: um registro por projeto ou produto do catálogo
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS projetos (
  id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  titulo           VARCHAR(255)    NOT NULL COMMENT 'nome do projeto, ex.: Acquora',
  breve_descricao  VARCHAR(500)    NOT NULL COMMENT 'frase curta do cartão do catálogo',
  categorias       VARCHAR(255)    NOT NULL COMMENT 'ex.: Saneamento',
  -- Código do estágio. Rótulos na tela: disponivel = "Disponível" e
  -- em_desenvolvimento = "Em desenvolvimento".
  estagio          VARCHAR(30)     NOT NULL DEFAULT 'em_desenvolvimento' COMMENT 'disponivel ou em_desenvolvimento',
  problema         TEXT            NOT NULL COMMENT 'texto de "O problema"',
  created_at       TIMESTAMP       NULL DEFAULT NULL,
  updated_at       TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- descricao_projetos: blocos de texto de cada projeto (título + texto)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS descricao_projetos (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  projeto_id  BIGINT UNSIGNED NOT NULL COMMENT 'projeto dono do bloco',
  titulo      VARCHAR(255)    NOT NULL COMMENT 'título do bloco',
  texto       TEXT            NOT NULL COMMENT 'conteúdo do bloco',
  created_at  TIMESTAMP       NULL DEFAULT NULL,
  updated_at  TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY descricao_projetos_projeto_id_foreign (projeto_id),
  -- Apagar o projeto apaga os blocos dele.
  CONSTRAINT descricao_projetos_projeto_id_foreign
    FOREIGN KEY (projeto_id) REFERENCES projetos (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
