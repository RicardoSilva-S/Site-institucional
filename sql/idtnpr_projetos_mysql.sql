-- =====================================================================
-- IDTNPR - Tabelas da página Projetos (MySQL)
--
-- Este arquivo espelha as migrations:
--   2026_10_15_120000_create_projetos_table
--   2026_10_15_130000_add_problema_to_projetos_table
--   2026_10_15_130100_create_descricao_projetos_table
-- Use-o só para montar o banco SEM o Laravel. Com `php artisan migrate` ele
-- não é necessário, e os dois não devem ser misturados no mesmo banco. Se uma
-- migration mudar, atualize este arquivo.
--
-- Origem: "Tabela de Projetos", passada pelo professor.
--   Projetos            -> título, breve descrição, categorias, estágio, problema
--   Descricao_projetos  -> IdProjeto, título, texto
--
-- Um projeto tem vários blocos de descrição (cada bloco é um título + um
-- texto). Relação 1 : N.
--
-- Decisões:
--   - projetos já era usada pela página /projetos e pelo painel, por isso
--     tem também tecnologia, link_rotulo, link_destino e ordem, além das
--     colunas do professor.
--   - problema é opcional, porque já existem projetos cadastrados e o painel
--     ainda não preenche esse campo.
--   - "IdProjeto" virou projeto_id, igual a secao_id em
--     transparencia_documentos.
--   - O script não escolhe banco (sem CREATE DATABASE nem USE): ele cria as
--     tabelas no banco que estiver selecionado na conexão.
-- =====================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- projetos: um registro por projeto ou solução do portfólio
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS projetos (
  id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  titulo           VARCHAR(255)    NOT NULL COMMENT 'nome do projeto, ex.: Totem de Autoatendimento',
  breve_descricao  VARCHAR(500)    NOT NULL COMMENT 'texto do cartão',
  categorias       VARCHAR(255)    NULL COMMENT 'Frente, no cartão',
  estagio          VARCHAR(30)     NOT NULL DEFAULT 'desenvolvimento' COMMENT 'implementado, expansao, consultoria, piloto ou desenvolvimento',
  tecnologia       VARCHAR(500)    NULL,
  link_rotulo      VARCHAR(255)    NULL COMMENT 'ex.: Conhecer a solução',
  link_destino     VARCHAR(30)     NOT NULL DEFAULT 'contato' COMMENT 'página para onde o link leva',
  ordem            INT UNSIGNED    NOT NULL DEFAULT 0,
  created_at       TIMESTAMP       NULL DEFAULT NULL,
  updated_at       TIMESTAMP       NULL DEFAULT NULL,
  -- Fica por último porque foi acrescentada depois (migration add_problema).
  problema         TEXT            NULL COMMENT 'texto de "O problema"',
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
