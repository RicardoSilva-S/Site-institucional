# Imagem para publicar o site no Render (https://render.com).
# PHP 7.4 é a versão travada no composer.json (config.platform.php).
FROM php:7.4-apache

# O Debian 11 (base da imagem PHP 7.4) saiu de suporte e foi movido para
# archive.debian.org; sem isso o apt-get dá 404. As linhas de "updates" e
# "security" ficam de fora porque ainda não existem no arquivo histórico.
RUN sed -i -e '/bullseye-updates/d' \
           -e '/debian-security/d' \
           -e 's|deb.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99archive

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev libzip-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# O Apache passa a servir a pasta public/ do Laravel.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
COPY . .
# Libera a gravação das imagens dos banners e permite uploads de até 4 MB.
RUN composer dump-autoload --optimize --no-dev \
    && mkdir -p public/uploads/banners \
    && chown -R www-data:www-data storage bootstrap/cache public/uploads \
    && { echo 'upload_max_filesize=5M'; echo 'post_max_size=8M'; } > /usr/local/etc/php/conf.d/uploads.ini
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["/usr/local/bin/start.sh"]
