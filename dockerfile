# Usa una imagen base de PHP con FPM (FastCGI Process Manager)
FROM php:8.2-fpm-alpine

# Instala extensiones de PHP y otras herramientas necesarias
# Se han combinado todas las instalaciones en un solo comando para optimizar
# el tamaño de la imagen y la velocidad de construcción.
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
    nodejs \
    npm \
    icu-dev;

# Instala Composer (gestor de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copia todo el código de tu aplicación CodeIgniter
COPY . .

# Instala las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Configura los permisos de escritura para las carpetas de caché y logs de CodeIgniter
RUN chmod -R 775 writable/ && \
    chown -R www-data:www-data writable/ && \
    chmod -R 775 public/uploads && \
    chown -R www-data:www-data public/uploads

# Expone el puerto 80 para el servidor web
EXPOSE 80

# Inicia los servicios con Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]