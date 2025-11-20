FROM node:20 AS frontend-builder

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

FROM php:8.2-fpm AS backend

RUN apt-get update && apt-get install -y \\
    git \\
    unzip \\
    libpq-dev \\
    libzip-dev \\
    libpng-dev \\
    libonig-dev \\
    libxml2-dev \\
    zip \\
    curl \\
    supervisor \\
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd xml

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

COPY --from=frontend-builder /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan storage:link || true

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY docker/entrypoints/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/start.sh"]
