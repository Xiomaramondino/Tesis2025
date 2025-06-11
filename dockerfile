# Usa una imagen base de PHP con FPM (FastCGI Process Manager)
FROM php:8.2-fpm-alpine

# Instala extensiones de PHP comunes y herramientas necesarias
# bcmath es común para CodeIgniter, mbstring, pdo_mysql si usas MySQL
# gd para manipulación de imágenes, opcache para rendimiento, zip para descompresión
# supervisor para gestionar procesos (Nginx y PHP-FPM)
# curl, unzip, git para herramientas de descarga y control de versiones
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
    supervisor \
    curl \
    unzip \
    git \
    # Si tu proyecto CodeIgniter usa npm para compilar assets (CSS/JS)
    # como Laravel Mix o Vite, NECESITAS estas líneas:
    nodejs npm \
    # Si no usas npm para assets, puedes quitar 'nodejs npm'
    ;

# Instala Composer (gestor de dependencias de PHP)
# Copia el binario de Composer desde una imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo dentro del contenedor
# Aquí es donde se copiará tu código de CodeIgniter
WORKDIR /var/www/html

# Copia TODO el código de tu aplicación CodeIgniter a la raíz del servidor web
# Asume que tu código CI4 (carpetas app/, public/, system/, etc.)
# está en la raíz de tu repositorio de GitHub.
COPY . .

# Instala las dependencias de Composer
# Esto leerá tu composer.json e instalará lo necesario en 'vendor/'
# --no-dev para no instalar dependencias de desarrollo, --optimize-autoloader para rendimiento
RUN composer install --no-dev --optimize-autoloader

# Configura los permisos de escritura para las carpetas de caché y logs de CodeIgniter
# CodeIgniter necesita escribir en estos directorios para funcionar
RUN chmod -R 775 writable/ && \
    chown -R www-data:www-data writable/ && \
    # Ajusta esta línea si tienes una carpeta de subidas de archivos (ej. public/uploads)
    # y necesita permisos de escritura
    chmod -R 775 public/uploads && \
    chown -R www-data:www-data public/uploads \
    ;

# --- Configuración de Nginx y PHP-FPM ---
# Borra la configuración predeterminada de Nginx
RUN rm /etc/nginx/conf.d/default.conf

# Copia la configuración personalizada de Nginx
# Esta configuración le dice a Nginx cómo servir tu CodeIgniter
COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

# Copia la configuración de PHP-FPM
# Ajusta el php-fpm.d/www.conf para que PHP-FPM sepa cómo procesar tus scripts
COPY docker/php-fpm/www.conf /etc/php82/php-fpm.d/www.conf

# Copia el script de inicio de Supervisor (para gestionar Nginx y PHP-FPM)
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# Expone el puerto 80 (puerto HTTP estándar)
EXPOSE 80

# Comando para iniciar Supervisor cuando el contenedor se inicie.
# Supervisor se encargará de mantener Nginx y PHP-FPM en funcionamiento.
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
