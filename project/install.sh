#install dependencies
composer install

#create database
php bin/console database:create

#run migrations
php bin/console migrations:migrate

#load fixtures
php bin/console doctrine:fixtures:load

php bin/console messenger:consume async -vv