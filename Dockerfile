FROM php:7.4.4-fpm-alpine3.11

RUN apk --no-cache add --virtual .build-deps $PHPIZE_DEPS \
    && apk --no-cache add --virtual .ext-deps libmcrypt-dev freetype-dev \
    libxml2-dev msmtp curl-dev zlib-dev pkgconfig openssl-dev icu-dev g++ \
    && docker-php-source extract \
    && docker-php-ext-install mysqli pdo pdo_mysql opcache \
    && docker-php-source delete \
    && apk del .build-deps

# install composer
SHELL ["/bin/ash", "-eo", "pipefail", "-c"]
RUN     curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer
RUN composer global require hirak/prestissimo

WORKDIR /app

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/app/web"]