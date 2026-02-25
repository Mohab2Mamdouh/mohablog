#!/bin/bash
# deploy.sh - Auto-deploy Laravel project

# Stop on any error
set -e

# Set HOME environment variable for composer
export HOME=/home/u409030087
export COMPOSER_HOME=$HOME/.composer

# Get the directory where this script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR" || exit 1

echo "Starting deployment at $(date)"
echo "Working directory: $(pwd)"

# 1. Pull latest changes from Git
echo "Pulling latest changes..."
git checkout .
git pull origin main

# 2. Install/update composer dependencies
echo "Installing composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Run database migrations
echo "Running migrations..."
php artisan migrate --force

# 4. Run database seeders
echo "Running seeders..."
php artisan generate:seed

# 4. Clear and cache configs, routes, views
echo "Clearing caches..."
php artisan o:c
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Set permissions (storage and cache folders)
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "Deployment completed successfully at $(date)"
