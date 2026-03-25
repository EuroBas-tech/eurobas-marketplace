rm -rf package
rm storage/install.zip
rm storage/update.zip

rsync -av --exclude '.env' --exclude 'auto_builder.sh' --exclude 'vendor/' --exclude '.git/' --exclude '.idea/' ./ ./package

cd package

composer update --no-interaction --prefer-dist

if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
fi

php artisan passport:keys --skip-if-exists
php artisan passport:client --personal --no-interaction

mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage/framework

php artisan prepare:installable
chmod -R 755 .
zip -r ../storage/install.zip .

php artisan prepare:updatable
rm -rf installation
rm .env
zip -r ../storage/update.zip .

pwd

cd ../
rm -rf package
