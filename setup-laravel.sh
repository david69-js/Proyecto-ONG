setup_laravel_env() {
    echo "Setting up Laravel environment..."
    
    cd /var/www/ong
    
    # Copy .env.example to .env if .env doesn't exist
    if [ ! -f ".env" ]; then
        su -s /bin/bash www-data -c "cp .env.example .env"
        echo ".env file created from .env.example"
    fi
    
    # Configure database settings in .env
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/g' .env
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=ong_db/g' .env
    sed -i 's/DB_USERNAME=root/DB_USERNAME=laravel_user/g' .env
    sed -i 's/DB_PASSWORD=/DB_PASSWORD=root/g' .env
    
    echo "Database configuration updated in .env"
    
    # 👉 Install dependencies BEFORE running artisan
    echo "Installing Composer dependencies..."
    su -s /bin/bash www-data -c "composer install --no-dev --optimize-autoloader"
    
    # Generate application key if not exists
    if ! grep -q "APP_KEY=base64:" .env; then
        echo "Generating application key..."
        su -s /bin/bash www-data -c "php artisan key:generate --no-interaction"
    fi
    
    # Create storage directories if they don't exist
    mkdir -p storage/logs
    mkdir -p storage/framework/cache
    mkdir -p storage/framework/sessions
    mkdir -p storage/framework/views
    mkdir -p bootstrap/cache
    
    # Set proper permissions
    chown -R www-data:www-data /var/www/ong
    chmod -R 775 storage bootstrap/cache
    
    echo "Laravel environment setup completed!"
}
