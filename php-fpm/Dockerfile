FROM nanoninja/php-fpm

ARG PHPbuild=dev

RUN apt-get update && apt-get install -y \
        ssh \
        git \
        wget \ 
        libssh2-1-dev \
        libssh2-1 \
        libssl-dev \
    && if [ "$PHPbuild" = "dev" ]; then pecl install xdebug; fi \
    && if [ "$PHPbuild" = "dev" ]; then docker-php-ext-enable xdebug; fi \
    && apt-get clean \
    && rm -rf /tmp/* /var/cache/apt/*
    

RUN cd /tmp && git clone https://git.php.net/repository/pecl/networking/ssh2.git && cd /tmp/ssh2 \
&& phpize && ./configure && make && make install \
&& echo "extension=ssh2.so" > /usr/local/etc/php/conf.d/ext-ssh2.ini \
&& rm -rf /tmp/ssh2


WORKDIR /var/www/php

# Install composer and libraries
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer require vlucas/phpdotenv --prefer-dist
# ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

CMD ["php-fpm"]