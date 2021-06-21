#https://gist.github.com/BenSampo/aa5f72584df79f679a7e603ace517c14

if [ -f ~/.profile ]; then
  . ~/.profile
fi

# Break on any error
set -e

SCRIPT_DIR="$(dirname "${BASH_SOURCE[0]}")"  # get the directory name
SCRIPT_DIR="$(realpath "${SCRIPT_DIR}")"     # resolve its full path

# Change to the project directory
cd ${SCRIPT_DIR}/..

# Load .env variables
source .env

# Выполняем команды в docker-контейнере PHP.
ARTISAN="docker exec ${PHP_CONTAINER} php artisan"
COMPOSER="docker exec ${PHP_CONTAINER} composer"

# Turn on maintenance mode
${ARTISAN} down || true

# Pull the latest changes from the git repository
git pull

# Set executable permissions
chmod +x ./bin/*.sh

# Install/update composer dependencies
${COMPOSER} install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run database migrations
${ARTISAN} migrate --force

# Clear caches
${ARTISAN} cache:clear
${ARTISAN} optimize:clear

# Install node modules
npm ci

# Build assets using Laravel Mix
npm run production

# Turn off maintenance mode
${ARTISAN} up