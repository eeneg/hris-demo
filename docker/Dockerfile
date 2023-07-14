FROM ubuntu:23.10

LABEL maintainer="Joowd"

ARG WWWGROUP

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN sed -i -e 's/http:\/\/archive\.ubuntu\.com\/ubuntu\//mirror:\/\/mirrors\.ubuntu\.com\/mirrors\.txt/' /etc/apt/sources.list

RUN apt-get update && apt-get install -y \
        build-essential ca-certificates composer cron curl git libc-ares-dev libcap2-bin libcurl4-openssl-dev libpng-dev \
        nodejs npm php-bcmath php-cli php-curl php-dev php-gd php-igbinary php-imap php-intl php-ldap php-mbstring php-memcached \
        php-msgpack php-mysql php-pgsql php-readline php-redis php-soap php-sqlite3 php-xml php-zip sqlite3 supervisor unzip zip \
    && pecl install -D 'enable-sockets="yes" enable-openssl="yes" enable-http2="yes" enable-mysqlnd="yes" enable-swoole-json="yes" enable-swoole-curl="yes" enable-cares="yes" with-postgres="yes"' swoole \
    && echo "zend_extension=opcache.so\nopcache.enable=1\nopcache.enable_cli=1\nopcache.jit_buffer_size=256M\nopcache.jit=tracing" > /etc/php/8.2/mods-available/opcache.ini \
    && echo "extension=swoole.so" >> /etc/php/8.2/cli/conf.d/20-swoole.ini \
    && apt-get -y autoremove && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.2

RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

RUN crontab -l | { cat; echo "* * * * * /usr/bin/php /var/www/html/artisan schedule:run >> /dev/null 2>&1"; } | crontab -

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.1/cli/conf.d/99-sail.ini
COPY start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

EXPOSE 8000

ENTRYPOINT ["start-container"]
