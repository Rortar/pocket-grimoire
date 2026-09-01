FROM node:20-bookworm-slim AS assets

WORKDIR /app

COPY package.json yarn.lock webpack.config.js ./
COPY assets ./assets

RUN corepack enable \
    && yarn install --frozen-lockfile \
    && yarn build

FROM php:8.2-cli AS vendor

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY composer.json composer.lock symfony.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --no-autoloader \
    --no-scripts

COPY bin ./bin
COPY config ./config
COPY src ./src

RUN composer dump-autoload --no-dev --optimize

FROM php:8.2-apache

ENV APP_ENV=prod \
    APP_DEBUG=0 \
    PORT=10000

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install opcache pdo_pgsql \
    && a2enmod headers rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY deploy/apache.conf /etc/apache2/sites-available/000-default.conf
COPY deploy/start.sh /usr/local/bin/pocket-grimoire-start

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

RUN chmod +x /usr/local/bin/pocket-grimoire-start \
    && mkdir -p var/cache var/log \
    && chown -R www-data:www-data var

EXPOSE 10000

CMD ["pocket-grimoire-start"]
