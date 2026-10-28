-- =====================================================================
-- IDTNPR - Diretoria/conselho (pagina Institucional) e Editais
-- MySQL 8. Nao escolhe banco (sem CREATE DATABASE nem USE): cria as
-- tabelas no banco selecionado na conexao. Pode rodar mais de uma vez.
-- So estrutura: os dados iniciais (6 membros e 4 editais) entram pelas
-- migrations insere_diretoria_e_conselho e insere_editais_iniciais.
-- =====================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- membros_institucionais: diretoria e conselho da pagina Institucional
-- (create_membros_institucionais_table). Editados em /adm/equipe.
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS membros_institucionais (
  id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  grupo            VARCHAR(20)     NOT NULL COMMENT 'diretoria ou conselho',
  nome             VARCHAR(255)    NOT NULL,
  cargo            VARCHAR(255)    NOT NULL,
  bio              TEXT            NULL COMMENT 'texto curto do cartao (diretoria)',
  foto_nome        VARCHAR(255)    NULL DEFAULT NULL COMMENT 'nome original, ex.: jonny.jpg',
  foto_mime        VARCHAR(50)     NULL DEFAULT NULL COMMENT 'ex.: image/jpeg',
  foto_data        LONGTEXT        NULL COMMENT 'foto em base64',
  foto_aproximada  TINYINT(1)      NOT NULL DEFAULT 0 COMMENT '1 = amplia a foto no cartao',
  ordem            INT UNSIGNED    NOT NULL DEFAULT 0,
  created_at       TIMESTAMP       NULL DEFAULT NULL,
  updated_at       TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY membros_institucionais_grupo_ordem_index (grupo, ordem)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- editais: editais e chamamentos publicos da pagina /editais
-- (create_editais_table). Cadastrados em /adm/editais.
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS editais (
  id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  titulo        VARCHAR(255)    NOT NULL,
  resumo        TEXT            NULL,
  status        VARCHAR(20)     NOT NULL DEFAULT 'aberto' COMMENT 'aberto, analise ou encerrado',
  abertura      DATE            NULL DEFAULT NULL,
  encerramento  DATE            NULL DEFAULT NULL,
  arquivo_nome  VARCHAR(255)    NULL DEFAULT NULL COMMENT 'nome original do PDF',
  arquivo_data  LONGTEXT        NULL COMMENT 'PDF em base64',
  created_at    TIMESTAMP       NULL DEFAULT NULL,
  updated_at    TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY editais_status_abertura_index (status, abertura)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
