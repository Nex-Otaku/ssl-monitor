#https://gist.github.com/BenSampo/aa5f72584df79f679a7e603ace517c14

if [ -f ~/.profile ]; then
  . ~/.profile
fi

SCRIPT_DIR="$(dirname "${BASH_SOURCE[0]}")"  # get the directory name
SCRIPT_DIR="$(realpath "${SCRIPT_DIR}")"     # resolve its full path

# Change to the project directory
cd ${SCRIPT_DIR}/..

# Turn on maintenance mode
php artisan down || true

# Pull the latest changes from the git repository
git pull

# Set executable permissions
chmod +x ./bin/*.sh

# Install/update composer dependecies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear
php artisan optimize:clear

# Install node modules
npm ci

# Build assets using Laravel Mix
npm run production

# Turn off maintenance mode
php artisan up