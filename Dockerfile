FROM php:8.2-apache

RUN a2enmod rewrite

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libssl-dev \
        pkg-config \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

WORKDIR /var/www/html

COPY . /var/www/html

RUN php -r "copy('https://getcomposer.org/installer','/tmp/composer-setup.php');" \
    && php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --prefer-dist --optimize-autoloader

RUN mkdir -p /var/www/html/uploads /var/www/html/back-end-php/formulaire_contact \
    && chown -R www-data:www-data /var/www/html/uploads /var/www/html/back-end-php/formulaire_contact \
    && chmod -R 775 /var/www/html/uploads /var/www/html/back-end-php/formulaire_contact
