#!/bin/bash

# 1. Download environment
aws s3 cp "s3://production-eurobas-assets/.env" /var/www/.env

# 2. Create required system directories & mPDF temp directory
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/vendor/mpdf/mpdf/tmp/mpdf

# 3. Install dependencies
composer install --ignore-platform-reqs --no-interaction --optimize-autoloader

# 4. Clear old Laravel config & routes & views safely
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 5. Pre-compile Blade views for speed
php artisan view:cache || true

# 6. Apply Secure & Correct Permissions AFTER composer & cache generation
echo "Setting up secure permissions..."
chmod -R 777 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache
chmod -R 775 /var/www/resources/lang
chmod -R 775 /var/www/public
chmod -R 775 /var/www/vendor/mpdf/mpdf/tmp

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/resources/lang /var/www/public /var/www/vendor/mpdf/mpdf/tmp

# 7. Run database migrations
php artisan migrate --path=database/migrations/2026_05_30_100001_create_user_reports_table.php --force || true
php artisan migrate --path=database/migrations/2026_05_30_100002_create_user_blocks_table.php --force || true
php artisan migrate --path=database/migrations/2026_05_30_100003_add_status_columns_to_chattings_table.php --force || true
php artisan migrate --path=database/migrations/2026_05_30_100004_create_seller_reviews_table.php --force || true

# 8. Symlink
ln -sf /var/www/public /var/www/public/public

# 9. Start supervisor
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
