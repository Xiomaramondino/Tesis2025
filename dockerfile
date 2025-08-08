# Use a PHP base image with FPM (FastCGI Process Manager)
FROM php:8.2-fpm-alpine

# Install common PHP extensions and necessary tools
# The php82-intl extension is included to resolve the dependency issue
RUN apk add --no-cache \
    nginx \
    php82-bcmath \
    php82-mbstring \
    php82-pdo_mysql \
    php82-mysqli \
    php82-dom \
    php82-xml \
    php82-ctype \
    php82-fileinfo \
    php82-session \
    php82-json \
    php82-tokenizer \
    php82-gd \
    php82-opcache \
    php82-zip \
    php82-intl \
    supervisor \
    curl \
    unzip \
    git \
    nodejs npm \
    ;

# Install Composer (PHP dependency manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy your entire CodeIgniter application code
COPY . .

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Configure write permissions for CodeIgniter's cache and log folders
RUN chmod -R 775 writable/ && \
    chown -R www-data:www-data writable/ && \
    chmod -R 775 public/uploads && \
    chown -R www-data:www-data public/uploads \
    ;

# Nginx and PHP-FPM Configuration
# Delete the default Nginx configuration file
RUN rm /etc/nginx/conf.d/default.conf
# Copy custom configuration files for Nginx, PHP-FPM, and Supervisor
COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/php-fpm/www.conf /etc/php82/php-fpm.d/www.conf
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# Expose port 80
EXPOSE 80

# Command to start Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]