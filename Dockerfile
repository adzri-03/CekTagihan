FROM php:8.2-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    curl \
    git \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring zip pdo pdo_mysql exif bcmath pcntl

# Clear cache (optional)
RUN apt-get clean && rm -rf /var/www/lib/apt/lists/*

# Install Imagick
RUN apt-get install -y libmagickwand-dev && pecl install imagick-3.5.1 && docker-php-ext-enable imagick

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Supervisord
RUN apt-get install -y supervisor

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

COPY docker/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Supervisord log file
RUN mkdir -p /var/www/storage/logs && chown -R www-data:www-data /var/www/storage

EXPOSE 9000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
