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
	&& docker-php-ext-install -j$(nproc) iconv mcrypt \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ENV APACHE_DOCUMENT_ROOT /application/public
ENV APP_HOME /application
ENV GALLERYPATH /photogallery
ENV APP_NAME PhotoGallery
ENV APP_DEBUG false
ENV DB_CONNECTION sqlite

RUN mkdir ${APP_HOME}

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN sed -i -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -i -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

WORKDIR ${APP_HOME}
COPY . ${APP_HOME}
RUN mkdir /photogallery
VOLUME /photogallery
VOLUME ${APP_HOME}/database/database.sqlite

EXPOSE 80

RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN touch .env
RUN echo "APP_KEY=" > .env
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan migrate --force --seed
RUN chown -R www-data:www-data $APP_HOME

RUN php artisan key:generate