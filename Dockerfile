# Dockerfile
FROM php:7-apache

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY start-apache /usr/local/bin
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN a2enmod rewrite

# use your users $UID and $GID below
RUN groupadd apache-www-volume -g 1000
RUN useradd apache-www-volume -u 1000 -g 1000

# Copy application source
COPY . /var/www
RUN chown -R apache-www-volume:apache-www-volume /var/www
WORKDIR /var/www

CMD ["start-apache"]