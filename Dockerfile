FROM adminer:4.8.1
USER root
RUN apk add autoconf gcc g++ make libffi-dev openssl-dev
RUN pecl install mongodb
RUN echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/docker-php-ext-mongodb.ini