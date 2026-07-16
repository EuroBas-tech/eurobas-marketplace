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

# 5. Run database migrations (ship schema changes with each deploy)
# NOTE: the migrations table has legacy drift (older migrations are "pending" but
# already applied), so a blanket `migrate` aborts before reaching new ones.
# Run the new migrations explicitly by path — each is idempotent (hasTable/hasColumn
# guards) so re-running is a safe no-op. Add new files here on each release.
php artisan migrate --path=database/migrations/2026_05_30_100001_create_user_reports_table.php --force || true
php artisan migrate --path=database/migrations/2026_05_30_100002_create_user_blocks_table.php --force || true
php artisan migrate --path=database/migrations/2026_05_30_100003_add_status_columns_to_chattings_table.php --force || true
php artisan migrate --path=database/migrations/2026_05_30_100004_create_seller_reviews_table.php --force || true

php artisan view:cache || true

# 6. Symlink
ln -sf /var/www/public /var/www/public/public

# 7. Start supervisor
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
