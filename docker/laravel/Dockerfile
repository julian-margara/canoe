FROM php:apache

EXPOSE 80

WORKDIR /

# Installing:
# libicu-dev: necessary for PHP intl extension
# zip, unzip, git: necessaries for Composer
RUN apt-get update && apt-get install -y libicu-dev libzip-dev zip unzip git libpng-dev libpq-dev cron supervisor
# MySql Driver
RUN docker-php-ext-install pdo_mysql
# PHP intl extension
RUN docker-php-ext-install intl
# Active Apache mod_rewrite
RUN a2enmod rewrite && a2dissite 000-default
# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Cleaning unnecessary packages after install all the things
RUN apt-get autoremove -y

#https://hub.docker.com/_/php - Configuration Section
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Setup cron job
RUN echo "* * * * * www-data cd /var/www/html/ && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontab
