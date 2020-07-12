FROM php:7.3-fpm-alpine

# Initiate required env vars at build time
ARG GA_CREDENTIALS_PATH=${GA_CREDENTIALS_PATH}
ARG PHP_OPCACHE_VALIDATE_TIMESTAMPS=${PHP_OPCACHE_VALIDATE_TIMESTAMPS}
# ENV is optional, without it the variable only exists at build time
# Add ENV at run time
ENV USERDIR /var/www
ENV WORKDIR ${USERDIR}/html
ENV ETCDIR ./etc/php
ENV PORT 9000
ENV GA_CREDENTIALS_PATH ${GA_CREDENTIALS_PATH}
ENV APPDIR ${WORKDIR}/wp-content/plugins/tasyakur-app

# Set working directory
WORKDIR ${WORKDIR}

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Add repos to alpine's apk
RUN echo "http://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories
RUN echo "http://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories

# Install required apk packages
RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
    $PHPIZE_DEPS \
    bash \
    ssmtp \
    libpng libpng-dev \
    zlib zlib-dev \
    libzip libzip-dev \
    # imagemagick imagemagick-libs imagemagick-dev \
    libffi-dev \
    supervisor
    # apk add --no-cache sendmail libpng-dev zlib1g-dev libzip-dev libmagickwand-dev

RUN docker-php-ext-install mbstring

RUN docker-php-ext-install zip

# Install php exts: GD (for S3 Offload plugin)
RUN docker-php-ext-install gd

# Install and enable imagemagick
# RUN pecl install imagick && \
#     docker-php-ext-enable imagick

# Install opcache
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=${PHP_OPCACHE_VALIDATE_TIMESTAMPS} \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"
RUN docker-php-ext-install opcache
COPY ${ETCDIR}/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Install and enable php redis
RUN pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install WP CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

# Copy GA json credentials file
COPY ${ETCDIR}/env_files/google/kontinentalist-s-1550564205410-6fed8ac55215.json ${GA_CREDENTIALS_PATH}

# Copy all conf files
COPY ${ETCDIR}/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ${ETCDIR}/uploads.ini /usr/local/etc/php/conf.d/uploads.ini
COPY ${ETCDIR}/logs.ini /usr/local/etc/php/conf.d/logs.ini

COPY ${ETCDIR}/crontab.txt /etc/cron.d/crontab.txt

# Add supervisor conf
COPY ${ETCDIR}/supervisord.conf /etc/supervisor/supervisord.conf
COPY ${ETCDIR}/supervisor_workers/ /etc/supervisor/conf.d/
# Create supervisor log dir
RUN mkdir -p /var/log/supervisor
# Create php-fpm log dir
RUN mkdir -p /var/log/php-fpm

# Copy start.sh script
COPY ${ETCDIR}/start.sh ${USERDIR}/scripts/start.sh
RUN chmod +x ${USERDIR}/scripts/start.sh


# Copy out app source code to the container
ADD ./src ${WORKDIR}

# Take the ownership of user dir to 'www-data' user and group, since php-fpm is compiled with user 'www-data' by default.
RUN chown -R www-data:www-data ${USERDIR}

# Expose port:
# - 9000 (php-fpm)
EXPOSE 9000
# Run any provision script: composer install, start php-fpm server, etc
CMD ["bash", "-c", "cd ${APPDIR} && ${USERDIR}/scripts/start.sh"]

# END