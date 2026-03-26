rm -rf package
rm storage/install.zip
rm storage/update.zip

rsync -av --exclude '.env' --exclude 'auto_builder.sh' --exclude 'vendor/' --exclude '.git/' --exclude '.idea/' ./ ./package

cd package

# 1. Update dependencies
composer update --no-interaction --prefer-dist

# 2. Setup Environment safely
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
fi

# 3. Passport Configuration (Sync with Secrets Manager)
# We don't need 'passport:keys' anymore because keys come from Environment Variables
# But we keep this to ensure the database has the Client ID
php artisan passport:client --personal --no-interaction

# 4. Framework Directory Setup
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage/framework

# 5. Build Installation Package
php artisan prepare:installable
chmod -R 755 .
zip -r ../storage/install.zip .

# 6. Build Update Package
php artisan prepare:updatable
rm -rf installation
rm .env
zip -r ../storage/update.zip .

pwd

cd ../
rm -rf package
