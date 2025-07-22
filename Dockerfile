# Dockerfile
FROM php:8.2-fpm-alpine

# Fix Alpine mirrors
RUN sed -i 's|dl-cdn.alpinelinux.org|dl-2.alpinelinux.org|' /etc/apk/repositories

# Install dependencies
RUN apk add --no-cache \
    bash curl git unzip \
    libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev \
    autoconf gcc g++ make pkgconf re2c file build-base

# Configure GD extension and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mysqli

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy Laravel project into container
COPY . .

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose optional port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
