#!/bin/sh
set -e

: "${APP_ENV:=prod}"
: "${APP_DEBUG:=0}"
: "${PORT:=10000}"

export APP_ENV APP_DEBUG PORT

sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9][0-9]*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

php bin/console cache:clear --no-warmup --env="${APP_ENV}"
php bin/console cache:warmup --env="${APP_ENV}"

if [ -n "${DATABASE_URL:-}" ]; then
    php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration --env="${APP_ENV}"
fi

chown -R www-data:www-data var

exec apache2-foreground
