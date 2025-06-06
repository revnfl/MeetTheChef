FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN a2enmod rewrite

# Salin dulu file composer.json dan composer.lock saja
COPY composer.json composer.lock ./

# Salin composer dari image official
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies composer (artisan belum ada tapi composer install bisa jalan)
RUN composer install --no-dev --optimize-autoloader

# Salin seluruh source code, termasuk artisan
COPY . .

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
