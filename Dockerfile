FROM php:8.2-fpm

# Install system dependencies (incluyendo las de GD)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configure and install GD with JPEG and FreeType support
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Create directory structure
RUN mkdir -p /var/www/ong

# Set working directory
WORKDIR /var/www/ong

# Copy setup script
COPY setup-laravel.sh /usr/local/bin/setup-laravel.sh
RUN chmod +x /usr/local/bin/setup-laravel.sh

# Set permissions for www-data
RUN chown -R www-data:www-data /var/www/ong

# Create entrypoint script that runs setup and then php-fpm
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]