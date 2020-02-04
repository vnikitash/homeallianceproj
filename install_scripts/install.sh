#!/bin/bash
tries=15;
try=0;
status=0;

cp .env.example .env
composer install
php artisan config:clear

while true; do
    php artisan migrate < /dev/null
    if [ $? -eq 0 ] && [ $try -lt $tries ]; then
        status="200";
        break
    fi
    sleep 15
    echo "Connecting DB FROM MAIN PHP IMAGE [attempt: $try]";
    try=$((try + 1))
done

if [ $status -ne "200" ]
then
    exit 1;
fi

php artisan passport:install
#php artisan db:seed