FROM php:8.1-apache-bullseye

ENV DOC_APACHE_SERVERNAME="future-presents" \
    DOC_APACHE_SERVERADMIN="thomasfagot39@gmail.com" \
	APACHE_RUN_USER="docker" \
    APACHE_RUN_GROUP="docker" \
    APACHE_LOG_DIR="/var/log/apache2"

# Installation des paquets globaux
RUN rm -rf /var/lib/apt/lists \
    && rm -rf /etc/apt/sources.list.d/* \
    && echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list \
    && apt-get --allow-releaseinfo-change update -y \
    && apt-get install -y \
    locales \
    nano \
    sudo \
    bash \
    nano \
    wget \
    curl git \
    nodejs yarn npm \
    libicu-dev \
    libzip-dev \
    unzip \
    default-mysql-client

# Extensions PHP
RUN apt install -y \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install pdo_mysql intl zip opcache \
    && pecl install apcu && docker-php-ext-enable apcu \
    && pecl install xdebug && docker-php-ext-enable xdebug && sed -i '1s/^/;Set XDEBUG_ENABLE=true to enable\n;/' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN a2enmod rewrite

COPY apache.conf /etc/apache2/sites-enabled/apache.conf
RUN rm /etc/apache2/sites-enabled/000-default.conf && rm /etc/apache2/sites-available/000-default.conf

RUN useradd -ms /bin/bash -u 1000 docker

RUN echo Europe/Paris > /etc/timezone

# Installation Composer
RUN cd /root \
    && wget -O composer-setup.php https://getcomposer.org/installer \
    && php composer-setup.php \
    && rm composer-setup.php \
    && mv composer.phar /usr/local/bin/composer

EXPOSE 80

USER docker

WORKDIR /var/www/html
