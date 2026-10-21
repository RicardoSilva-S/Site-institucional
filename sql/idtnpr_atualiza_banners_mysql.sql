-- =====================================================================
-- IDTNPR - Atualiza a tabela banners de um banco criado com a versao
-- antiga do idtnpr_conteudo_mysql.sql (sem device/width/height/
-- display_title). Equivale a migration
-- 2026_10_08_180000_add_device_and_display_title_to_banners_table.php.
--
-- ATENCAO: rode UMA vez so. Se as colunas ja existirem, o MySQL da
-- "Duplicate column name" e nada e alterado.
-- Banco criado do zero com o idtnpr_conteudo_mysql.sql atual NAO precisa.
-- =====================================================================

SET NAMES utf8mb4;

ALTER TABLE banners
  ADD COLUMN device         VARCHAR(10)       NOT NULL DEFAULT 'desktop' COMMENT 'desktop (computador) ou mobile (celular)',
  ADD COLUMN width          SMALLINT UNSIGNED NULL DEFAULT NULL COMMENT 'largura da imagem em pixels, ex.: 1920',
  ADD COLUMN height         SMALLINT UNSIGNED NULL DEFAULT NULL COMMENT 'altura da imagem em pixels, ex.: 700',
  ADD COLUMN display_title  VARCHAR(255)      NULL DEFAULT NULL COMMENT 'texto escrito sobre a imagem no site (title = nome interno no painel)';

-- Banners que ja existiam: o titulo que aparecia no site continua aparecendo.
UPDATE banners SET display_title = title WHERE display_title IS NULL;
