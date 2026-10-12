-- =====================================================================
-- IDTNPR - Painel administrativo e autenticacao (users, sessions e tabelas padrao do Laravel)
-- MySQL 8. Nao escolhe banco (sem CREATE DATABASE nem USE): cria as
-- tabelas no banco selecionado na conexao. Pode rodar mais de uma vez.
-- =====================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- users: usuarios do painel administrativo
-- (create_users_table + add_papel_ativo_to_users_table)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id                 BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name               VARCHAR(255)    NOT NULL,
  email              VARCHAR(255)    NOT NULL,
  email_verified_at  TIMESTAMP       NULL DEFAULT NULL,
  password           VARCHAR(255)    NOT NULL,
  remember_token     VARCHAR(100)    NULL DEFAULT NULL,
  created_at         TIMESTAMP       NULL DEFAULT NULL,
  updated_at         TIMESTAMP       NULL DEFAULT NULL,
  papel              VARCHAR(20)     NOT NULL DEFAULT 'editor' COMMENT 'admin ou editor',
  ativo              TINYINT(1)      NOT NULL DEFAULT 1,
  ultimo_login       TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- sessions: sessoes de login guardadas no banco
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS sessions (
  id             VARCHAR(255)    NOT NULL,
  user_id        BIGINT UNSIGNED NULL DEFAULT NULL,
  ip_address     VARCHAR(45)     NULL DEFAULT NULL,
  user_agent     TEXT            NULL,
  payload        LONGTEXT        NOT NULL,
  last_activity  INT             NOT NULL,
  PRIMARY KEY (id),
  KEY sessions_user_id_index (user_id),
  KEY sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- password_resets: tokens de redefinicao de senha (padrao do Laravel)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS password_resets (
  email       VARCHAR(255) NOT NULL,
  token       VARCHAR(255) NOT NULL,
  created_at  TIMESTAMP    NULL DEFAULT NULL,
  KEY password_resets_email_index (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- personal_access_tokens: tokens de API (padrao do Laravel)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS personal_access_tokens (
  id             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  tokenable_type VARCHAR(255)    NOT NULL,
  tokenable_id   BIGINT UNSIGNED NOT NULL,
  name           VARCHAR(255)    NOT NULL,
  token          VARCHAR(64)     NOT NULL,
  abilities      TEXT            NULL,
  last_used_at   TIMESTAMP       NULL DEFAULT NULL,
  created_at     TIMESTAMP       NULL DEFAULT NULL,
  updated_at     TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY personal_access_tokens_token_unique (token),
  KEY personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- failed_jobs: tarefas em fila que falharam (padrao do Laravel)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS failed_jobs (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  uuid        VARCHAR(255)    NOT NULL,
  connection  TEXT            NOT NULL,
  queue       TEXT            NOT NULL,
  payload     LONGTEXT        NOT NULL,
  exception   LONGTEXT        NOT NULL,
  failed_at   TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY failed_jobs_uuid_unique (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
