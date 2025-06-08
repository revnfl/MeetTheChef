ARG PHP_EXTENSIONS="apcu bcmath pdo_mysql redis imagick gd"
ARG NODE_ENV=development

# Tahap 1: PHP base - install composer dependencies dan Laravel setup
FROM thecodingmachine/php:8.3-v4-fpm AS php_base

ENV TEMPLATE_PHP_INI=production
ENV APP_ENV=production

WORKDIR /var/www/html

# Salin composer files dan install dependencies PHP tanpa dev dan scripts
COPY --chown=docker:docker composer.json composer.lock ./
RUN composer install --no-scripts --no-dev --optimize-autoloader --quiet

# Salin seluruh source code aplikasi
COPY --chown=docker:docker . .

# Jalankan package discover Laravel (optimasi)
RUN php artisan package:discover --ansi

# Tahap 2: Node build - install node modules dan build assets
FROM node:18 AS node_dependencies

WORKDIR /var/www/html

ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=false
ARG NODE_ENV=development
ENV NODE_ENV=${NODE_ENV}

# Salin source code dari tahap php_base
COPY --from=php_base /var/www/html /var/www/html

# Install node_modules sesuai package-lock.json secara konsisten dengan npm ci
RUN npm set progress=false && \
    npm config set depth 0 && \
    npm ci && \
    npm run build && \
    rm -rf node_modules && \
    npm cache clean --force

# Tahap 3: Final PHP container - salin source dan hasil build assets
FROM thecodingmachine/php:8.3-v4-fpm

ENV TEMPLATE_PHP_INI=production
ENV APP_ENV=production

WORKDIR /var/www/html

# Salin source code dari php_base
COPY --from=php_base /var/www/html /var/www/html

# Salin hasil build assets dari tahap node_dependencies
COPY --from=node_dependencies /var/www/html/public/build /var/www/html/public/build

# Salin konfigurasi php-fpm khusus
COPY ./docker-config/www.conf /usr/local/etc/php-fpm.d/www.conf

# Caching config dan route untuk performa lebih baik
RUN php artisan config:cache && php artisan route:cache

# Opsional: sesuaikan permission (uncomment jika diperlukan)
# RUN chown -R docker:docker /var/www/html
