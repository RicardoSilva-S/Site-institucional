-- =====================================================================
-- IDTNPR - Contato e Ouvidoria (mensagens enviadas pelo site)
-- MySQL 8. Nao escolhe banco (sem CREATE DATABASE nem USE): cria as
-- tabelas no banco selecionado na conexao. Pode rodar mais de uma vez.
-- =====================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- contact_messages: mensagens do formulario de Contato
-- (create_contact_messages_table). Lidas no painel em /adm/mensagens.
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS contact_messages (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome        VARCHAR(255)    NOT NULL,
  cargo       VARCHAR(255)    NULL DEFAULT NULL,
  orgao       VARCHAR(255)    NOT NULL COMMENT 'orgao/prefeitura de quem escreveu',
  email       VARCHAR(255)    NULL DEFAULT NULL,
  telefone    VARCHAR(30)     NULL DEFAULT NULL,
  area        VARCHAR(255)    NULL DEFAULT NULL COMMENT 'area de interesse escolhida no formulario',
  mensagem    TEXT            NOT NULL,
  read_at     TIMESTAMP       NULL DEFAULT NULL COMMENT 'preenchido quando alguem do painel marca como lida',
  created_at  TIMESTAMP       NULL DEFAULT NULL,
  updated_at  TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- manifestacoes_ouvidoria: manifestacoes da Ouvidoria
-- (create_manifestacoes_ouvidoria_table). Lidas em /adm/ouvidoria.
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS manifestacoes_ouvidoria (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  tipo        VARCHAR(30)     NOT NULL COMMENT 'reclamacao, denuncia, sugestao...',
  anonimo     TINYINT(1)      NOT NULL DEFAULT 0,
  nome        VARCHAR(255)    NULL DEFAULT NULL COMMENT 'vazio quando anonimo',
  email       VARCHAR(255)    NULL DEFAULT NULL,
  telefone    VARCHAR(30)     NULL DEFAULT NULL,
  mensagem    TEXT            NOT NULL,
  status      VARCHAR(20)     NOT NULL DEFAULT 'recebida' COMMENT 'recebida ou respondida',
  created_at  TIMESTAMP       NULL DEFAULT NULL,
  updated_at  TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
