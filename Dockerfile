FROM php:8.2-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_pgsql

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Копируем ВСЮ папку src (где будет код)
COPY src/ .

# Если src пустая, создаем .env чтобы не было ошибок
RUN if [ ! -f .env ]; then echo "APP_NAME=ForexApp" > .env; fi

# Права
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache 2>/dev/null || true

EXPOSE 9000
CMD ["php-fpm"]