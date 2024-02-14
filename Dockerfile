FROM php:8-alpine

WORKDIR /var/www

# Install Composer
RUN apk --no-cache add curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy your application files
COPY . /var/www

# Install dependencies
RUN composer install

# Expose the port
EXPOSE 8080

# Command to run the application
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]