FROM php:8.2-apache

WORKDIR /var/www

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN apt-get update \
    && apt-get install -y --no-install-recommends locales git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev unzip librust-glib-sys-dev apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev build-essential libnss3-dev libxcb1-dev


RUN curl -sS https://getcomposer.org/installer | php -- --disable-tls && mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql gd opcache intl zip exif calendar dom mbstring zip xsl

#INSTALL XDEBUG
RUN pecl install xdebug && docker-php-ext-enable xdebug
#XDEBUG

#INSTALL APCU
RUN pecl install apcu && docker-php-ext-enable apcu
RUN echo "extension=apcu.so" > /usr/local/etc/php/php.ini
RUN echo "apc.enable_cli=1" > /usr/local/etc/php/php.ini
RUN echo "apc.enable=1" > /usr/local/etc/php/php.ini
RUN echo "memory_limit = 512M" > /usr/local/etc/php/php.ini
#APCU
