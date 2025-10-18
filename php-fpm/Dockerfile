FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/laravel

# Копируем всё сразу
COPY ./auth-service .

# Устанавливаем зависимости (artisan уже есть)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Настраиваем права
RUN chown -R www-data:www-data /var/www/laravel/storage /var/www/laravel/bootstrap/cache \
    && chmod -R 775 /var/www/laravel/storage /var/www/laravel/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]

