#!/bin/sh

GRAY='\033[1;30m'
LIGHT_GRAY='\033[0;37m'
CYAN='\033[0;36m'
LIGHT_CYAN='\033[1;36m'
RED='\033[0;31m'
GREEN='\033[0;32m'
NC='\033[0m'

abort()
{
    echo >&2 "
${RED}********************
*** BUILD FAILED ***
********************
${NC}"
    exit 1
}

trap 'abort' 0

set -e

# Run some general commands so we're up-to-date
composer self-update
composer install --no-interaction --optimize-autoloader
php artisan config:clear

# Setup DB
#touch database/database.sqlite
#php artisan migrate --database=database/database.sqlite --env=testing

# Start tests
echo >&2 "${CYAN}PHP Lint Test${NC}"
vendor/bin/parallel-lint --exclude vendor --exclude _ide_helper.php .
echo >&2 "${CYAN}PHPMD${NC}"
vendor/bin/phpmd app/ text phpmd.xml
echo >&2 "${CYAN}PHP Fixable PSR2 Issues${NC}"
vendor/bin/phpcbf --standard=psr2 app/
echo >&2 "${CYAN}PHP Coding Standards${NC}"
vendor/bin/phpcs --standard=psr2 --colors app/
echo >&2 "${CYAN}PHPUnit${NC}"
vendor/bin/phpunit

# Remove DB
#rm database/database.sqlite

trap : 0

echo >&2 "
${GREEN}********************
*** BUILD PASSED ***
********************
${NC}"