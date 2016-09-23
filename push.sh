#!/bin/bash

./vendor/bin/php-cs-fixer fix ./tests/
./vendor/bin/php-cs-fixer fix ./src/

composer dump-autoload --optimize

git add .
git commit -m 'push commit'
git push
