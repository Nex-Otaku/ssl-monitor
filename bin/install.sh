# Установка проекта на хост.

if [ -f ~/.profile ]; then
  . ~/.profile
fi

# Break on any error
set -e

SCRIPT_DIR="$(dirname "${BASH_SOURCE[0]}")"  # get the directory name
SCRIPT_DIR="$(realpath "${SCRIPT_DIR}")"     # resolve its full path

# Change to the project directory
cd ${SCRIPT_DIR}/..

git config core.fileMode false
[ -f ".env" ] && echo "ENV exists, skipping copying" || cp .env.example .env

docker-compose up -d

# Load .env variables
source .env

# Выполняем команды в docker-контейнере PHP.
ARTISAN="docker exec ${PHP_CONTAINER} php artisan"
COMPOSER="docker exec ${PHP_CONTAINER} composer"

${COMPOSER} install
${COMPOSER} dump-autoload --no-interaction
${ARTISAN} key:generate
${ARTISAN} cache:clear

# Set executable permissions
chmod +x ./bin/*.sh
