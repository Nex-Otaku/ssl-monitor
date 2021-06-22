#!/usr/bin/env bash

# https://laravel-news.com/laravel-scheduler-queue-docker

set -e

# Container role is set in docker-compose.yml
role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then

    exec php-fpm

elif [ "$role" = "queue" ]; then

    echo "Queue role"
    exit 1

elif [ "$role" = "scheduler" ]; then

    while [ true ]
    do
      php /var/www/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else
    echo "Could not match the container role \"$role\""
    exit 1
fi