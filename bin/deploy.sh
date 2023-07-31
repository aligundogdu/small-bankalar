git pull
export COMPOSER_ALLOW_SUPERUSER=1
composer install --prefer-dist
php bin/console cache:clear
php bin/console doctrine:schema:update --force --dump-sql
