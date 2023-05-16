FROM php:8.1-cli-alpine AS builder

RUN apk add --no-cache postgresql-dev icu-dev libzip-dev zip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql intl opcache zip

RUN apk add --no-cache unzip

ENV COMPOSER_ALLOW_SUPERUSER 1

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY ./composer.json ./composer.lock ./

RUN composer install --no-dev --prefer-dist --no-progress --no-suggest --optimize-autoloader --no-scripts --ignore-platform-reqs \
    && rm -rf /root/.composer/cache

COPY ./ ./

RUN composer dump-autoload

ARG APP_URL
ENV APP_URL ${APP_URL}

RUN composer docs

FROM nginx:1.23-alpine

RUN apk add --no-cache curl

COPY ./docker/common/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app

COPY --from=builder /app/public/docs/v1/openapi.json ./public/docs/v1/openapi.json
COPY ./public ./public

HEALTHCHECK --interval=5s --timeout=3s --start-period=1s CMD curl --fail http://127.0.0.1/health || exit 1
