FROM php:7.2.5-fpm

MAINTAINER Sergey Cherkesov <sergey.cherkesov.1006@gmail.com>

RUN apt-get update
RUN apt-get -y install git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y curl
RUN apt-get install -y gnupg
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs

RUN npm install --global yarn

RUN apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install pgsql pdo pdo_pgsql

EXPOSE 9000
WORKDIR /var/www/html