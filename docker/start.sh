#!/bin/sh
# Roda a cada deploy no Render, antes de subir o servidor.
set -e

# O Render informa a porta na variável PORT.
PORT="${PORT:-10000}"
sed -ri "s/Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# A chave gerada pelo Render vem em base64 sem o prefixo que o Laravel espera.
case "$APP_KEY" in
  base64:*) ;;
  *) export APP_KEY="base64:${APP_KEY}" ;;
esac

php artisan config:clear
php artisan migrate --force   # cria/atualiza as tabelas no banco
php artisan db:seed --force   # cria (ou atualiza) o usuário do painel
php artisan config:cache
php artisan view:cache

exec apache2-foreground
