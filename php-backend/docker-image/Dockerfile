FROM php:8.0-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

COPY ./composer.installer.sh /usr/local/bin
RUN chmod +x /usr/local/bin/composer.installer.sh
RUN /usr/local/bin/composer.installer.sh

COPY ./start.project.sh /usr/local/bin
RUN chmod +x /usr/local/bin/start.project.sh

RUN a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

CMD /usr/local/bin/start.project.sh
