FROM php:8.2-fpm

ARG APP_ENV

# UPDATE LOCAL DATETIME
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime

# UPDATE & UPGRADE SERVER
RUN apt-get update && apt-get -y upgrade

# INSTALL DEPENDENCY
RUN apt-get install -y ca-certificates curl gnupg wget tar bzip2 gzip yasm git unzip librabbitmq-dev
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
RUN echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_18.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list
RUN apt-get update
RUN apt-get -y install nodejs

# INSTALL PHP EXTENSION
RUN if [ "$APP_ENV" = "dev" ]; then pecl install xdebug; fi
RUN pecl install apcu
RUN pecl install amqp
RUN if [ "$APP_ENV" = "dev" ]; then docker-php-ext-enable xdebug; fi
RUN docker-php-ext-enable apcu
RUN docker-php-ext-enable amqp
RUN docker-php-ext-install opcache
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install pdo_mysql

RUN mkdir /app
WORKDIR /app

# INSTALL COMPOSER
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer; chmod +x /usr/local/bin/composer

# INSTALL YARN
RUN npm install -g yarn

# INIT THE PROJECT
COPY ./docker/app/entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
