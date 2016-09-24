#!/bin/bash

./vendor/bin/php-cs-fixer fix ./tests/
./vendor/bin/php-cs-fixer fix ./src/

composer dump-autoload --optimize

./vendor/bin/phpunit
