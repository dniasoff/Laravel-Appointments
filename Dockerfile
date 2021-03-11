FROM php:7.4-fpm


# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/vww


# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u 1000 -d /home/www www
RUN mkdir -p /home/web/.composer && \
    chown -R www:www /home/www && \
    chown -R www:www /var/www



RUN set -eux; \
    mkdir -p storage/logs storage/framework bootstrap/cache; \
    composer install --prefer-dist --no-progress --no-suggest --optimize-autoloader; \
    composer clear-cache

COPY docker/php-fpm/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod a+x /usr/local/bin/docker-entrypoint.sh

WORKDIR /var/www
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
USER www