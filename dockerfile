# Usa una imagen base de PHP con FPM (FastCGI Process Manager)
FROM php:8.2-fpm-alpine

# Instala extensiones de PHP comunes y herramientas necesarias
RUN apk add --no-cache \
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
    curl \
    unzip \
    git \
    nodejs npm \
    ;

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
    chown -R www-data:www-data public/uploads \
    ;

# Expone el puerto 8080, que es el puerto predeterminado del servidor de desarrollo de CodeIgniter
EXPOSE 8080

# Comando para iniciar el servidor de desarrollo de CodeIgniter
CMD ["php", "spark", "serve", "--host=0.0.0.0", "--port=8080"]