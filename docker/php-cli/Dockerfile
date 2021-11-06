FROM php:8-cli

# Install extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions zip pdo_pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

# Install pgsql client
RUN apt-get update
RUN apt-get install -y postgresql-client

# Place wait for postgres script
COPY wait-for-it.sh wait-for-it.sh
RUN chmod +x wait-for-it.sh
