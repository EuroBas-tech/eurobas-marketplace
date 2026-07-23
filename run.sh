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
# mPDF temp directory — required for PDF generation
mkdir -p /var/www/vendor/mpdf/mpdf/tmp/mpdf
chmod -R 775 /var/www/vendor/mpdf/mpdf/tmp
chown -R www-data:www-data /var/www/vendor/mpdf/mpdf/tmp
# 4. Clear old Laravel cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
# Fix views directory permissions after view:clear
chmod -R 777 /var/www/storage/framework/views/
chown -R www-data:www-data /var/www/storage/framework/views/
# 5. Run database migrations
php artisan migrate --path=database/migrations/2026_05_30_100001_create_user_reports_table.php --force || true
php artisan migrate --path=database/migrations/2026_05_30_100002_create_user_blocks_table.php --force || true
php artisan migrate --path=database/migrations/2026_05_30_100003_add_status_columns_to_chattings_table.php --force || true
php artisan migrate --path=database/migrations/2026_05_30_100004_create_seller_reviews_table.php --force || true

# 6. Build Laravel caches for performance
php artisan config:cache
php artisan view:cache || true
# Fix views directory permissions after view:cache
chmod -R 777 /var/www/storage/framework/views/
chown -R www-data:www-data /var/www/storage/framework/views/
# 7. Symlink
ln -sf /var/www/public /var/www/public/public
# 8. Start supervisor
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
