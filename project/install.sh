cd /var/www/project

#install dependencies
composer install

#create database
php bin/console doctrine:database:create --if-not-exists

#run migrations
php bin/console doctrine:migrations:migrate --no-interaction

#load fixtures
php bin/console doctrine:fixtures:load --no-interaction

# install the cron job
cd /var/spool/cron/crontabs && touch root && chmod 600 root && chown root:crontab root
echo "*/15 * * * * /usr/local/bin/php /var/www/project/bin/console app:parse-news >> /var/log/cron.log 2>&1" > /var/spool/cron/crontabs/root
/etc/init.d/cron start
/etc/init.d/cron reload
/etc/init.d/cron restart

# change directory to the project dir
cd /var/www/project

# run the parser to initialize the data
php bin/console app:parse-news

# run consumer to receive the async tasks from rabbitMq
php bin/console messenger:consume async -vv