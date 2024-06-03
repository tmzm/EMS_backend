##!/usr/bin/env bash
#echo "Running composer"
#composer global require hirak/prestissimo
#composer install --no-dev --working-dir=/var/www/html
#
#echo "generating application key..."
#php artisan key:generate --show
#
#echo "Caching config..."
#php artisan config:cache
#
#echo "Caching routes..."
#php artisan route:cache
#
#echo "Running migrations..."
#php artisan migrate --force
#
#echo "Running seed..."
#php artisan db:seed
#
#echo "Running app..."
#php artisan serve --host 0.0.0.0 --port 10000

echo "Running passport..."
php passport client --personal
