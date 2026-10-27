-- =====================================================================
-- IDTNPR - Cria o usuario administrador do painel (/adm)
-- MySQL 5.7+ / 8. Nao escolhe banco (sem CREATE DATABASE nem USE): age no
-- banco selecionado na conexao.
--
-- POR QUE EXISTE: no servidor nao da para rodar "php artisan db:seed", que e
-- quem cria o admin. Sem nenhum usuario na tabela users ninguem entra no
-- painel. Este script faz o mesmo que o AdminUserSeeder.
--
-- COMO USAR (a senha NUNCA vai para o Git):
--   1. Gere o hash da senha no seu computador (precisa do PHP):
--        php -r "echo password_hash('SENHA-ESCOLHIDA', PASSWORD_BCRYPT), PHP_EOL;"
--      O resultado comeca com $2y$10$ (60 caracteres).
--   2. Troque os dois valores entre aspas logo abaixo (e-mail e hash).
--      O e-mail deve ser o mesmo ADMIN_EMAIL do .env do servidor.
--   3. Rode o arquivo. Nao guarde o arquivo preenchido.
--
-- Pode rodar mais de uma vez: se o e-mail ja existe, nada e alterado.
-- Se o hash continuar o texto de exemplo, nada e inserido.
-- Depois do primeiro login, troque a senha pelo painel (/adm/usuarios).
-- =====================================================================

SET NAMES utf8mb4;

SET @admin_email = 'admin@idtnpr.org.br';
SET @admin_hash  = 'COLE_AQUI_O_HASH_BCRYPT';

-- O IGNORE pula a linha se o e-mail ja existir (users.email e unico).
INSERT IGNORE INTO users (name, email, email_verified_at, password, papel, ativo, created_at, updated_at)
SELECT 'Administrador IDTNPR', @admin_email, NOW(), @admin_hash, 'admin', 1, NOW(), NOW()
FROM DUAL
WHERE @admin_hash LIKE '$2y$%';

-- Deve mostrar o administrador (papel admin, ativo 1):
SELECT id, name, email, papel, ativo FROM users WHERE papel = 'admin';
