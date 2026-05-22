#!/bin/bash

# 1. Download environment
aws s3 cp "s3://production-eurobas-assets/.env" /var/www/.env

# 2. Install dependencies
composer install --ignore-platform-reqs --no-interaction --optimize-autoloader

# 3. Permissions
echo "Setting up secure permissions..."

chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache
chmod -R 775 /var/www/resources/lang
chmod -R 775 /var/www/public

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/resources/lang /var/www/public

# 4. Clear old Laravel cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 5. Rebuild optimized cache
php artisan config:cache
php artisan route:cache
php artisan view:cache || true

# 6. Symlink
ln -sf /var/www/public /var/www/public/public

# 7. Start supervisor
exec /usr/bin/supervisord -n -c '/etc/supervisor/conf.d/supervisord.conf'
