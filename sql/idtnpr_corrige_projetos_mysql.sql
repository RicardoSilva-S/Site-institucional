-- =====================================================================
-- IDTNPR - Corrige a tabela projetos criada pela versao antiga do .sql
-- MySQL 5.7+ / 8. Nao escolhe banco (sem CREATE DATABASE nem USE): age no
-- banco selecionado na conexao.
--
-- QUANDO USAR: so em banco que ja tem a tabela projetos feita pelo
-- idtnpr_projetos_mysql.sql ANTIGO (sem as colunas tecnologia, link_rotulo,
-- link_destino e ordem). Sem isso a pagina /projetos da erro 500
-- ("Unknown column 'ordem'"). Banco novo nao precisa: o
-- idtnpr_projetos_mysql.sql atual ja cria a tabela certa.
--
-- RODE UMA VEZ. Se aparecer "Duplicate column name", ja foi aplicado.
-- Os dados que ja estiverem na tabela sao mantidos.
-- =====================================================================

SET NAMES utf8mb4;

ALTER TABLE projetos
  MODIFY categorias VARCHAR(255) NULL COMMENT 'Frente, no cartao (pode ficar vazia)',
  MODIFY estagio    VARCHAR(30)  NOT NULL DEFAULT 'desenvolvimento' COMMENT 'implementado, expansao, consultoria, piloto ou desenvolvimento',
  MODIFY problema   TEXT         NULL COMMENT 'texto de "O problema" (pode ficar vazio)',
  ADD COLUMN tecnologia   VARCHAR(500) NULL AFTER estagio,
  ADD COLUMN link_rotulo  VARCHAR(255) NULL COMMENT 'ex.: Conhecer a solucao' AFTER tecnologia,
  ADD COLUMN link_destino VARCHAR(30)  NOT NULL DEFAULT 'contato' COMMENT 'pagina para onde o link leva' AFTER link_rotulo,
  ADD COLUMN ordem        INT UNSIGNED NOT NULL DEFAULT 0 AFTER link_destino;

-- Os codigos de estagio da versao antiga viram os que o site usa hoje.
UPDATE projetos SET estagio = 'implementado'    WHERE estagio = 'disponivel';
UPDATE projetos SET estagio = 'desenvolvimento' WHERE estagio = 'em_desenvolvimento';
