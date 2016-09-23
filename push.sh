#!/bin/bash

./vendor/bin/php-cs-fixer fix ./tests/
./vendor/bin/php-cs-fixer fix ./src/

composer dump-autoload --optimize
phpunit

sleep 20
git add .
sleep 20
git commit -m 'push commit'
sleep 2
git push
