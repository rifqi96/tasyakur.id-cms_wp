#!/bin/sh

# Add cronjobs to crontab
crontab /etc/cron.d/crontab.txt

# Start cron
crond -l 8

# If vendor folder exists, don't composer install unless --composer-i option is set
if [ ! -d "vendor" ] || [ "$FORCE_COMPOSER_INSTALL" == "true" ] ; then
    composer install --prefer-dist --no-scripts --no-dev --no-autoloader
    composer dump-autoload --no-scripts --no-dev --optimize
fi

# Run supervisord in the background
supervisord -c /etc/supervisor/supervisord.conf

# Run main php-fpm service
php-fpm