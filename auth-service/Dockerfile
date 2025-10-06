FROM php:8.2-fpm

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Указываем рабочую директорию
WORKDIR /var/www/html

# Копируем файлы Laravel-приложения
COPY . .

# Устанавливаем зависимости Laravel
RUN composer install --no-interaction --prefer-dist

# Открываем порт, на котором работает php-fpm
EXPOSE 9000

# Команда запуска PHP-FPM
CMD ["php-fpm"]