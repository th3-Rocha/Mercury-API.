FROM php:8.3-fpm

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
      git \
      unzip \
      curl \
      libonig-dev \
      libzip-dev \
    ; \
    docker-php-ext-install -j"$(nproc)" \
      pdo_mysql \
      mbstring \
      zip \
      bcmath \
      pcntl \
      opcache \
    ; \
    rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN set -eux; \
    printf "opcache.enable=1\n" \
      "opcache.enable_cli=0\n" \
      "opcache.validate_timestamps=1\n" \
      "opcache.revalidate_freq=1\n" \
      > /usr/local/etc/php/conf.d/opcache.ini

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
