FROM php:7.3-fpm

ARG environment=dev

RUN if [ $environment != "prod" ]; then pecl install xdebug && docker-php-ext-enable xdebug; fi

RUN rm -f /usr/local/etc/www.conf.default && rm -f /usr/local/etc/docker.conf && rm -f /usr/local/etc/zz-docker.conf

RUN mkdir ~/.ssh
RUN echo 'Host github.com\n\
            StrictHostKeyChecking no\n\
            IdentityFile ~/.ssh-local/id_rsa' > ~/.ssh/config

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip

COPY docker/fpm/config/php_dev.ini /usr/local/etc/php/php.ini
COPY docker/fpm/config/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/fpm/config/www_dev.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /usr/src/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
