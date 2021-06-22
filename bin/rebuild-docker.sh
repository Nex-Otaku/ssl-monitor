# Обновление контейнеров докера.

if [ -f ~/.profile ]; then
  . ~/.profile
fi

# Break on any error
set -e

SCRIPT_DIR="$(dirname "${BASH_SOURCE[0]}")"  # get the directory name
SCRIPT_DIR="$(realpath "${SCRIPT_DIR}")"     # resolve its full path

# Change to the project directory
cd ${SCRIPT_DIR}/..

docker-compose down --remove-orphans
docker-compose build
docker-compose up -d
