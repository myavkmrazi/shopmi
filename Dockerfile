# Используем официальный образ PHP с Apache
FROM php:8.2-apache

# Устанавливаем необходимые системные зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# Включаем модуль Apache rewrite (нужен для работы маршрутов Laravel)
RUN a2enmod rewrite

# Настраиваем Document Root для Laravel (папка public)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем файлы проекта
WORKDIR /var/www/html
COPY . .

# Устанавливаем зависимости и настраиваем права
RUN composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Открываем порт 80
EXPOSE 80

# Apache запускается автоматически, дополнительные скрипты не нужны
CMD ["apache2-foreground"]
