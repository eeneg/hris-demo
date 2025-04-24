FROM ubuntu:22.04

LABEL maintainer="Joowd"

ARG WWWGROUP

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

# Set timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Use faster mirror
RUN sed -i -e 's|http://archive.ubuntu.com/ubuntu/|mirror://mirrors.ubuntu.com/mirrors.txt|' /etc/apt/sources.list

# Install PHP & system deps
RUN apt-get update && apt-get install -y \
    software-properties-common lsb-release ca-certificates curl gnupg \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get update && apt-get install -y \
    build-essential ca-certificates cron curl git unzip zip \
    libc-ares-dev libssl-dev libbrotli-dev libcap2-bin libcurl4-openssl-dev libpng-dev \
    nodejs npm composer \
    php8.2 php8.2-cli php8.2-bcmath php8.2-curl php8.2-dev php8.2-gd php8.2-igbinary php8.2-imap php8.2-intl \
    php8.2-ldap php8.2-mbstring php8.2-memcached php8.2-msgpack php8.2-mysql php8.2-pgsql php8.2-readline \
    php8.2-redis php8.2-soap php8.2-sqlite3 php8.2-xml php8.2-zip php8.2-opcache sqlite3 supervisor \
    && pecl install swoole \
    && echo "extension=swoole.so" > /etc/php/8.2/cli/conf.d/25-swoole.ini \
    && echo "zend_extension=opcache.so\nopcache.enable=1\nopcache.enable_cli=1\nopcache.jit_buffer_size=256M\nopcache.jit=tracing" > /etc/php/8.2/cli/conf.d/10-opcache.ini \
    && apt-get -y autoremove && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Allow PHP to bind to ports <1024
RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.2

# Create dev user
RUN groupadd --force -g $WWWGROUP sail && \
    useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

# Add Laravel scheduler to cron
RUN crontab -l | { cat; echo "* * * * * /usr/bin/php /var/www/html/artisan schedule:run >> /dev/null 2>&1"; } | crontab -

# Copy config files
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.2/cli/conf.d/99-sail.ini
COPY start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

EXPOSE 8000

ENTRYPOINT ["start-container"]
