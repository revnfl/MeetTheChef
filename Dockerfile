ARG PHP_EXTENSIONS="apcu bcmath pdo_mysql redis imagick gd"
FROM thecodingmachine/php:8.3-v4-fpm AS php_base
ENV TEMPLATE_PHP_INI=production
WORKDIR /var/www/html

# Step 1: copy only composer files first (better Docker caching)
COPY --chown=docker:docker composer.json composer.lock ./
RUN composer install --no-scripts --no-dev --optimize-autoloader --quiet

# Step 2: copy the rest of the Laravel app
COPY --chown=docker:docker . .

# 📌 Step 2b: jalankan artisan sekarang setelah semua file lengkap
RUN php artisan package:discover --ansi

# Step 3: build assets using node
FROM node:14 AS node_dependencies
WORKDIR /var/www/html
ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=false

COPY --from=php_base /var/www/html /var/www/html
RUN npm set progress=false && \
    npm config set depth 0 && \
    npm install && \
    npm run prod && \
    rm -rf node_modules

# Step 4: final PHP container
FROM thecodingmachine/php:8.3-v4-fpm
ENV TEMPLATE_PHP_INI=production
WORKDIR /var/www/html

COPY --from=php_base /var/www/html /var/www/html
COPY --from=node_dependencies /var/www/html/public /var/www/html/public
# COPY --from=node_dependencies /var/www/html/mix-manifest.json /var/www/html/mix-manifest.json
