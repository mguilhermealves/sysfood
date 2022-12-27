FROM php:7.2-apache
COPY gerenciador.conf /etc/apache2/sites-available/gerenciador.conf
COPY site.conf /etc/apache2/sites-available/site.conf
RUN a2ensite gerenciador.conf
RUN a2ensite site.conf
RUN apt-get update 
RUN apt-get install -y apt-utils
RUN apt-get install -y libzip-dev 
RUN apt-get install -y zlib1g-dev
RUN docker-php-ext-install mysqli zip
RUN a2enmod headers rewrite
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd
#RUN usermod -u root www-data