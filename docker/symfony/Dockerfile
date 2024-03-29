ARG PHP_VERSION=latest
FROM php:${PHP_VERSION}-fpm-alpine

RUN set -eux; \
  apk add --no-cache --virtual .composer-rundeps \
    bash \
    coreutils \
    git \
    make \
    mercurial \
    openssh-client \
    patch \
    mysql-client \
    subversion \
    tini \
    unzip \
    zip

RUN set -eux; \
  apk add --no-cache --virtual .build-deps \
    icu-dev \
    libxml2-dev \
    libxslt-dev \
    libzip-dev \
    mysql-dev \
    zlib-dev \
  ; \
  docker-php-ext-install -j "$(nproc)" \
    intl \
    pdo \
    mysqli \
    pdo_mysql \
    soap \
    xsl \
    zip \
  ; \
  runDeps="$( \
    scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
      | tr ',' '\n' \
      | sort -u \
      | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )"; \
  apk add --no-cache --virtual .composer-phpext-rundeps $runDeps; \
  apk del .build-deps

RUN printf "# composer php cli ini settings\n\
date.timezone=UTC\n\
memory_limit=-1\n\
" > $PHP_INI_DIR/php-cli.ini

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_VERSION 2.4.4
ENV COMPOSER_INSTALLER_URL https://raw.githubusercontent.com/composer/getcomposer.org/cb19f2aa3aeaa2006c0cd69a7ef011eb31463067/web/installer
ENV COMPOSER_INSTALLER_HASH 48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5

RUN set -eux; \
  curl --silent --fail --location --retry 3 --output /tmp/installer.php --url ${COMPOSER_INSTALLER_URL}; \
  php -r " \
    \$signature = '${COMPOSER_INSTALLER_HASH}'; \
    \$hash = hash('sha384', file_get_contents('/tmp/installer.php')); \
    if (!hash_equals(\$signature, \$hash)) { \
      unlink('/tmp/installer.php'); \
      echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
      exit(1); \
    }"; \
  php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION}; \
  composer --ansi --version --no-interaction; \
  rm -f /tmp/installer.php; \
  find /tmp -type d -exec chmod -v 1777 {} +

# install phpunit
RUN wget https://phar.phpunit.de/phpunit-6.1.phar && \
    chmod +x phpunit-6.1.phar && \
    mv phpunit-6.1.phar /usr/local/bin/phpunit

WORKDIR /usr/src/symfony
ENV PS1="\u@\h:\w\\$ "
