#!/bin/bash
tries=30;
try=0;
status=0;

while true; do
    php artisan migrate < /dev/null
    if [ $? -eq 0 ] && [ $try -lt $tries ]; then
        status="200";
        break
    fi
    sleep 15
    echo "Testing correct app ready to be tested: [attempt: $try of $tries]";
    try=$((try + 1))
done

if [ $status -ne "200" ]
then
    exit 1;
fi

mkdir tests/acceptance
mkdir tests/unit
mkdir tests/functional

php vendor/bin/codecept run -d