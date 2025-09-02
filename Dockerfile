FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/ong

# No necesitamos copiar los archivos aquí porque se montarán como volumen
# COPY . /var/www/ong

# Eliminamos la instalación de Composer aquí, ya que se ejecutará después de montar los archivos
# RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permissions
RUN mkdir -p /var/www/ong/storage /var/www/ong/bootstrap/cache
RUN chown -R www-data:www-data /var/www/ong

EXPOSE 9000
CMD ["php-fpm"]