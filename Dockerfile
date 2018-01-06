FROM php:7.1-apache

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
	&& rm -r /var/lib/apt/lists/* \
	&& docker-php-ext-install \
	intl \
	mbstring \
	mcrypt \
	pcntl \
	pdo_sqlite \
	zip \
	opcache \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ENV APP_HOME /var/www/html

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite

COPY . $APP_HOME

RUN composer install --no-interaction
RUN chown -R www-data:www-data $APP_NAME
