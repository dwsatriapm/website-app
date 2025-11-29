FROM php:7.4-apache
RUN docker-php-ext-install mysqli pdo_mysql

RUN echo "upload_max_filesize=64M" >> /usr/local/etc/php/conf.d/docker-php-upload.ini
RUN echo "post_max_size=64M" >> /usr/local/etc/php/conf.d/docker-php-upload.ini

RUN chown -R www-data:www-data /var/www/html