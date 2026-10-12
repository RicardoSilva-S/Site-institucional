-- =====================================================================
-- IDTNPR - Conteudo do site (textos editaveis e banners)
-- MySQL 8. Nao escolhe banco (sem CREATE DATABASE nem USE): cria as
-- tabelas no banco selecionado na conexao. Pode rodar mais de uma vez.
-- =====================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- site_texts: textos editaveis das paginas do site (painel /adm)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS site_texts (
  id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  page         VARCHAR(255)    NOT NULL COMMENT 'shared, home, institucional...',
  `group`      VARCHAR(255)    NOT NULL COMMENT 'hero, problem, footer...',
  group_label  VARCHAR(255)    NOT NULL COMMENT 'nome da secao mostrado no painel',
  `key`        VARCHAR(255)    NOT NULL COMMENT 'ex.: home.hero.title',
  label        VARCHAR(255)    NOT NULL COMMENT 'nome do campo mostrado no painel',
  `value`      TEXT            NULL,
  `long`       TINYINT(1)      NOT NULL DEFAULT 0 COMMENT 'texto longo (area de texto)',
  custom       TINYINT(1)      NOT NULL DEFAULT 0 COMMENT '1 = inserido pelo painel',
  sort_order   INT UNSIGNED    NOT NULL DEFAULT 0,
  created_at   TIMESTAMP       NULL DEFAULT NULL,
  updated_at   TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY site_texts_key_unique (`key`),
  KEY site_texts_page_group_index (page, `group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- site_content_values: textos editados no painel antigo (/admin/conteudo).
-- Tabela antiga; os textos hoje ficam em site_texts.
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS site_content_values (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `key`       VARCHAR(255)    NOT NULL COMMENT 'ex.: home.hero.title',
  `value`     TEXT            NULL,
  created_at  TIMESTAMP       NULL DEFAULT NULL,
  updated_at  TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY site_content_values_key_unique (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- banners: imagens do carrossel e imagens ao lado das secoes
-- (create_banners_table + add_slot + add_image_data)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS banners (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  page        VARCHAR(255)    NULL DEFAULT NULL COMMENT 'nome da rota; NULL = todas as paginas',
  slot        VARCHAR(255)    NULL DEFAULT NULL COMMENT 'NULL = carrossel do topo; ex.: governanca = imagem ao lado da secao',
  image       VARCHAR(255)    NOT NULL COMMENT 'caminho dentro de public/',
  title       VARCHAR(255)    NULL DEFAULT NULL,
  subtitle    VARCHAR(500)    NULL DEFAULT NULL,
  link        VARCHAR(255)    NULL DEFAULT NULL,
  sort_order  INT UNSIGNED    NOT NULL DEFAULT 0,
  active      TINYINT(1)      NOT NULL DEFAULT 1,
  created_at  TIMESTAMP       NULL DEFAULT NULL,
  updated_at  TIMESTAMP       NULL DEFAULT NULL,
  image_mime  VARCHAR(50)     NULL DEFAULT NULL COMMENT 'ex.: image/jpeg',
  image_data  LONGTEXT        NULL COMMENT 'imagem em base64',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
