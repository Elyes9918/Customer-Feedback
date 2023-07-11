# Use the official PHP-FPM image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    git \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-configure intl && \
    docker-php-ext-install intl pdo pdo_mysql

# Set the working directory
WORKDIR /var/www/html

# Copy the project files to the working directory
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --no-interaction --optimize-autoloader

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Run PHP-FPM
CMD ["php-fpm"]







