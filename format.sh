#!/bin/bash
set -e
set -x
./vendor/bin/php-cs-fixer fix ./tests/
./vendor/bin/php-cs-fixer fix ./src/
