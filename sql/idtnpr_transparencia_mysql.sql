-- =====================================================================
-- IDTNPR - Portal da Transparencia (secoes e documentos)
-- MySQL 8. Nao escolhe banco (sem CREATE DATABASE nem USE): cria as
-- tabelas no banco selecionado na conexao. Pode rodar mais de uma vez.
-- =====================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- transparencia_secoes: secoes do Portal da Transparencia
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS transparencia_secoes (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug        VARCHAR(255)    NOT NULL,
  titulo      VARCHAR(255)    NOT NULL,
  subtitulo   VARCHAR(255)    NULL DEFAULT NULL,
  ordem       INT UNSIGNED    NOT NULL DEFAULT 0,
  created_at  TIMESTAMP       NULL DEFAULT NULL,
  updated_at  TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY transparencia_secoes_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- transparencia_documentos: documentos de cada secao (PDF em base64)
-- Relacao 1 : N com transparencia_secoes.
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS transparencia_documentos (
  id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  secao_id      BIGINT UNSIGNED NOT NULL,
  nome          VARCHAR(255)    NOT NULL,
  detalhe       VARCHAR(255)    NULL DEFAULT NULL,
  status        VARCHAR(20)     NOT NULL DEFAULT 'publicado' COMMENT 'publicado, publicacao ou elaboracao',
  arquivo_nome  VARCHAR(255)    NULL DEFAULT NULL COMMENT 'nome original do PDF',
  arquivo_data  LONGTEXT        NULL COMMENT 'conteudo do PDF em base64',
  ordem         INT UNSIGNED    NOT NULL DEFAULT 0,
  created_at    TIMESTAMP       NULL DEFAULT NULL,
  updated_at    TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY transparencia_documentos_secao_id_foreign (secao_id),
  -- Apagar a secao apaga os documentos dela.
  CONSTRAINT transparencia_documentos_secao_id_foreign
    FOREIGN KEY (secao_id) REFERENCES transparencia_secoes (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
