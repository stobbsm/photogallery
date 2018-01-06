FROM php:7.1-apache
LABEL com.sproutinggallery.version="1,0,0" \
			 com.sproutinggallery.description="PHP Based photo management for use on a server"
LABEL maintainer="Matthew Stobbs <matthew@sproutingcommunications.com"

RUN apt-get update && apt-get install -y \
	libicu-dev \
	libpq-dev \
	libmcrypt-dev \
	git \
	zip \
	unzip \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libmcrypt-dev \
	libpng-dev \
	libsqlite3-dev \
	libsqlite3-0 \
	sqlite3 \
	&& rm -r /var/lib/apt/lists/* \
	&& docker-php-ext-install \
	intl \
	mbstring \
	mcrypt \
	pcntl \
	pdo_sqlite \
	zip \
	opcache \
	&& docker-php-ext-configure -J$(nproc) gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ENV APACHE_DOCUMENT_ROOT /application/public
ENV APP_HOME /application

RUN mkdir ${APP_HOME}

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN sed -i -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -i -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/config-available/*.conf
RUN a2enmod rewrite

WORKDIR ${APP_HOME}
COPY . ${APP_HOME}
RUN mkdir /photogallery
VOLUME /photogallery
VOLUME ${APP_HOME}/database/database.sql

ENV GALLERYPATH /photogallery

EXPOSE 80

RUN composer install --no-interaction
RUN chown -R www-data:www-data $APP_HOME