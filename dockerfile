# Imagen base con PHP 8.2 y FPM (Alpine para tamaño reducido)
FROM php:8.2-fpm-alpine

# 1. Instala dependencias del sistema y extensiones PHP esenciales para CI4
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    unzip \
    git \
    # Dependencias para extensiones PHP
    icu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    # Extensiones requeridas por composer.json
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        intl \
        mbstring \
        pdo_mysql \
        zip \
        gd \
        opcache \
    && docker-php-ext-enable intl opcache

# 2. Verifica que las extensiones estén activas
RUN php -m | grep -E 'intl|mbstring|pdo_mysql' && \
    php -i | grep 'GD Support' && \
    echo "extension=zip.so" >> /usr/local/etc/php/conf.d/docker-php-ext-zip.ini

# 3. Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Configura el directorio de trabajo
WORKDIR /var/www/html

# 5. Copia solo los archivos necesarios para composer primero (optimización de caché)
COPY composer.json composer.lock ./

# 6. Instala dependencias (ignora temporalmente la verificación de plataforma)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 7. Copia toda la aplicación
COPY . .

# 8. Configura permisos para CodeIgniter
RUN chown -R www-data:www-data /var/www/html/writable && \
    chmod -R 775 /var/www/html/writable

# 9. Configuración de Nginx y Supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/supervisord.conf

# 10. Puerto expuesto
EXPOSE 80

# 11. Comando de inicio
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]