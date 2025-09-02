setup_laravel_env() {
    echo "Setting up Laravel environment..."
    cd /var/www/ong

    # Copy .env.example if .env doesn't exist
    if [ ! -f ".env" ]; then
        su -s /bin/bash www-data -c "cp .env.example .env"
        echo ".env file created from .env.example"
    fi

    # Update DB config from environment variables
    sed -i "s/DB_HOST=.*/DB_HOST=${DB_HOST}/" .env
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=${DB_DATABASE}/" .env
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=${DB_USERNAME}/" .env
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD}/" .env
    echo "Database configuration updated in .env"

    # Generate APP_KEY if missing
    if ! grep -q "APP_KEY=base64:" .env; then
        echo "Generating application key..."
        su -s /bin/bash www-data -c "php artisan key:generate --no-interaction"
    fi

    # Install dependencies
    echo "Installing Composer dependencies..."
    su -s /bin/bash www-data -c "composer install --no-dev --optimize-autoloader"

    # Create storage directories
    mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

    # Set permissions
    chown -R www-data:www-data /var/www/ong
    chmod -R 775 storage bootstrap/cache

    echo "Laravel environment setup completed!"
}
