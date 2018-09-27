#!/usr/bin/env bash

# Local development runtime concerns
if [ ${_buildEnv} == "local" ]; then
    # xdebug
    pecl install xdebug
    docker-php-ext-enable xdebug

    # Move PHP configs
    cp /opt/provision/php/php.ini $PHP_INI_DIR/php.ini
    cp /opt/provision/php/conf.d/developer.ini $PHP_INI_DIR/conf.d/developer.ini

    cat /opt/provision/php/conf.d/30-xdebug.ini | \
        sed "s|_extensionFilePath|$(find /usr/local/lib/php/extensions/ -name 'xdebug.so')|g" \
    > $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

    # Handle the Apache config
    rm /etc/apache2/sites-enabled/*.conf

    cat /opt/provision/apache/sites-enabled/app-80.conf | \
        sed "s|_serverAlias|hackathon.local|g" \
    > /etc/apache2/sites-enabled/app-80.conf
fi

apache2-foreground
