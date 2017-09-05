FROM php:7.0-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
libssl-dev \
pkg-config \
zip \
unzip \
git

RUN pecl install mongodb \
&& docker-php-ext-enable mongodb

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
&& php -r "unlink('composer-setup.php');"

WORKDIR /var/www

RUN rm -rf /var/lib/apt/lists/*