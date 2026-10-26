#!/bin/sh
# Monta o pacote do site para o servidor do professor (systemluz.com.br/idtnpr).
# Uso: sh scripts/montar-pacote-servidor.sh [pasta-de-saida]
# Precisa do Docker aberto. Nao precisa de PHP nem Composer instalados.
#
# A raiz do FTP ja e a pasta publica (/idtnpr), entao:
#   raiz/          -> o que o navegador acessa (index.php, css, js, imagens)
#   raiz/laravel/  -> o resto do projeto (bloqueado no nginx com deny all)
# Ver docs/deploy-servidor.md.
set -e

REPO="$(cd "$(dirname "$0")/.." && pwd)"
DEST="${1:-$REPO/../deploy-idtnpr/site}"

rm -rf "$DEST"
mkdir -p "$DEST/laravel"

# so o que esta commitado (nada de arquivo solto do pc)
git -C "$REPO" archive HEAD | tar -x -C "$DEST/laravel"

# bibliotecas de producao para o PHP 8.3 do servidor
docker run --rm -v "$DEST/laravel":/app -w /app composer:2 \
    composer install --no-dev --optimize-autoloader --no-scripts --no-interaction -q --ignore-platform-req=ext-*
docker run --rm -v "$DEST/laravel":/app -w /app php:8.3-cli php artisan package:discover -q

# o que nao vai pro servidor
cd "$DEST/laravel"
rm -rf tests phpunit.xml docker Dockerfile render.yaml scripts docs sql .github .sonarcloud.properties README-banco-de-dados.md node_modules AGENTS.md CLAUDE.md
rm -f public/.htaccess   # o servidor e nginx; o .htaccess da pasta e do professor

# conteudo de public/ vai pra raiz e o index.php aponta pra laravel/
mv public/* "$DEST/"
rmdir public
sed -i.bak "s#__DIR__.'/../#__DIR__.'/laravel/#" "$DEST/index.php" && rm "$DEST/index.php.bak"

# .env de producao sem a senha do banco (preencher DB_PASSWORD antes de subir)
cat > "$DEST/laravel/.env" <<EOF
APP_NAME=IDTNPR
APP_ENV=production
APP_KEY=base64:$(openssl rand -base64 32)
APP_DEBUG=false
APP_URL=http://systemluz.com.br/idtnpr

LOG_CHANNEL=errorlog
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=siteInstitucional
DB_USERNAME=siteInstitucional
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
MAIL_MAILER=log

ADMIN_NAME="Administrador IDTNPR"
ADMIN_EMAIL=admin@idtnpr.org.br
EOF

echo "pacote pronto em $DEST"
echo "falta: preencher DB_PASSWORD em $DEST/laravel/.env"
