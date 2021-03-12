#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ]; then
    mkdir -p storage/logs
    

    if [ "$APP_ENV" != 'prod' ]; then
        composer install --prefer-dist --no-progress  --no-interaction
    fi
    
    echo "creating database"
    php artisan make:database $DB_DATABASE
    echo "database created"

    if [ "$(ls -A database/migrations/*.php 2> /dev/null)" ]; then
        echo "Migrations..."
        php artisan migrate --force
    fi

    # Queue worker
    php artisan queue:work --daemon &

fi

exec docker-php-entrypoint "$@"
