FROM php:8.2-apache

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd \
    && a2enmod rewrite

# Настройка Apache для Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY . .
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка зависимостей и права
RUN composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# САМОЕ ВАЖНОЕ: запускаем apache напрямую
CMD ["apache2-foreground"]
