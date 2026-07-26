FROM php:8.3-apache

# Install dependency dan PHP extension Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
        mbstring \
        bcmath \
        intl \
    && a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Folder kerja Laravel
WORKDIR /var/www/html

# Copy project Laravel
COPY . .

# Install dependency Laravel
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# Laravel permission
RUN chown -R www-data:www-data storage bootstrap/cache

# Apache config Laravel
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Port Render
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]