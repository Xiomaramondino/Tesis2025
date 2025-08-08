# Usa una imagen base de PHP con FPM (FastCGI Process Manager)
FROM php:8.2-fpm-alpine

# Instala las herramientas del sistema y las dependencias de desarrollo necesarias
# El paquete 'icu-dev' es necesario para la extensión 'intl'
RUN apk add --no-cache \
    nginx \
    icu-dev \
    supervisor \
    curl \
    unzip \
    git \
    nodejs npm \
    ;

# Instala y habilita las extensiones de PHP usando el método recomendado por Docker
RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    mbstring \
    pdo_mysql \
    mysqli \
    dom \
    xml \
    ctype \
    fileinfo \
    session \
    tokenizer \
    gd \
    opcache \
    zip \
    intl \
    ;

# Instala Composer (gestor de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copia todo el código de tu aplicación CodeIgniter al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Configura los permisos de escritura para las carpetas de caché y logs de CodeIgniter
RUN chmod -R 775 writable/ && \
    chown -R www-data:www-data writable/ && \
    chmod -R 775 public/uploads && \
    chown -R www-data:www-data public/uploads \
    ;

# --- Configuración de Nginx y PHP-FPM ---
# Elimina el archivo de configuración predeterminado de Nginx
RUN rm /etc/nginx/conf.d/default.conf
# Copia los archivos de configuración personalizados para Nginx, PHP-FPM y Supervisor
COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/php-fpm/www.conf /etc/php82/php-fpm.d/www.conf
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# Expone el puerto 80 para el tráfico web
EXPOSE 80

# Comando para iniciar Supervisor cuando el contenedor arranca
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]