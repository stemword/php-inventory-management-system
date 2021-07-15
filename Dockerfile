FROM php:7.3-apache

COPY . /var/www/html

COPY docker_script/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN apt update && apt install curl && apt install net-tools && apt install -y vim && docker-php-ext-install mysqli
RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite
