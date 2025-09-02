#!/bin/bash

# Ensure we're running as root for permissions
if [ "$(id -u)" != "0" ]; then
    echo "Script must run as root for proper permissions handling"
    exit 1
fi

# Change ownership of the working directory to www-data
chown -R www-data:www-data /var/www/ong

# Function to check if Laravel project exists
check_laravel_exists() {
    if [ -f "artisan" ] && [ -f "composer.json" ] && [ -d "app" ] && [ -d "config" ]; then
        echo "Laravel project detected!"
        return 0
    else
        echo "No Laravel project found."
        return 1
    fi
}

# Function to create new Laravel project
create_laravel_project() {
    echo "Creating new Laravel project..."
    
    cd /var/www/ong
    
    # Check if directory has files (except hidden files)
    if [ "$(ls -A . 2>/dev/null | grep -v '^\.')" ]; then
        echo "Directory has some files, but proceeding with Laravel installation..."
    fi
    
    # Create Laravel project as www-data user
    su -s /bin/bash www-data -c "composer create-project --prefer-dist laravel/laravel /tmp/laravel-temp"
    
    # Move all files from temp directory to current directory
    su -s /bin/bash www-data -c "
        cp -r /tmp/laravel-temp/* /var/www/ong/ 2>/dev/null || true
        cp -r /tmp/laravel-temp/.[!.]* /var/www/ong/ 2>/dev/null || true
        rm -rf /tmp/laravel-temp
    "
    
    echo "Laravel project created successfully!"
}

# Function to setup Laravel environment
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
    
    # Generate application key if not exists
    if ! grep -q "APP_KEY=base64:" .env; then
        echo "Generating application key..."
        su -s /bin/bash www-data -c "php artisan key:generate --no-interaction"
    fi
    
    # Install dependencies if vendor directory doesn't exist
    if [ ! -d "vendor" ]; then
        echo "Installing Composer dependencies..."
        su -s /bin/bash www-data -c "composer install --no-dev --optimize-autoloader"
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

# Function to wait for database
wait_for_db() {
    echo "Waiting for database connection..."
    
    cd /var/www/ong
    max_attempts=30
    attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        if su -s /bin/bash www-data -c "php artisan migrate:status" >/dev/null 2>&1; then
            echo "Database connection established!"
            break
        else
            echo "Attempt $attempt/$max_attempts: Database not ready yet..."
            sleep 2
            attempt=$((attempt + 1))
        fi
    done
    
    if [ $attempt -gt $max_attempts ]; then
        echo "Warning: Could not establish database connection after $max_attempts attempts"
        echo "Application will start anyway. You may need to run migrations manually."
    fi
}

# Function to run migrations
run_migrations() {
    echo "Running database migrations..."
    
    cd /var/www/ong
    
    # Check if migrations table exists, if not create it
    if ! su -s /bin/bash www-data -c "php artisan migrate:status" >/dev/null 2>&1; then
        echo "Creating migrations table..."
        su -s /bin/bash www-data -c "php artisan migrate:install --no-interaction"
    fi
    
    # Run migrations
    su -s /bin/bash www-data -c "php artisan migrate --no-interaction --force"
    
    echo "Migrations completed!"
}

# Main execution
echo "Starting Laravel setup process..."

# Check if Laravel project already exists
if check_laravel_exists; then
    echo "Using existing Laravel project."
else
    create_laravel_project
fi

# Setup Laravel environment
setup_laravel_env

# Wait for database and run migrations
wait_for_db
run_migrations

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm