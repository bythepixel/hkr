FROM php:7.2-apache

# Update and source packages
RUN apt-get update -y \
  && apt-get install -y \
  zlib1g-dev \
  libjpeg-dev \
  libpng-dev \
  libfreetype6-dev \
  libcurl4-gnutls-dev \
  libxml2-dev \
  libmcrypt-dev \
  libjpeg62-turbo-dev \
  libvpx-dev \
  vim \
  curl \
  mysql-client \
  && rm -rf /var/lib/apt/lists/*

RUN pecl install mcrypt-1.0.1 && \
  docker-php-ext-enable mcrypt

# Phpize extensions
RUN docker-php-ext-install -j$(nproc) \
  pdo_mysql \
  mysqli \
  mbstring \
  tokenizer

# GD config & install
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/  &&  \
  docker-php-ext-install gd && \
  docker-php-ext-install bcmath

# Enable apache mods
RUN a2enmod \
  headers \
  rewrite \
  ssl \
  status \
  include \
  proxy \
  proxy_http

# Prep directories
RUN mkdir -p /srv/logs
RUN chown www-data:www-data /srv -R

COPY . /srv/www
RUN mkdir -p /srv/www/temp
RUN mv /srv/www/provision /opt/provision

# Move config files into place
RUN cp /opt/provision/apache/apache2.conf /etc/apache2/apache2.conf

WORKDIR /srv/www

ENTRYPOINT ["/opt/provision/entrypoint.sh"]

