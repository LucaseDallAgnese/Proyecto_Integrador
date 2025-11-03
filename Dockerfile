# Usamos una imagen base de PHP 8.2 con FPM (FastCGI Process Manager)
FROM php:8.2-fpm-alpine

# Argumentos para el usuario y grupo
ARG UID
ARG GID

# Instalar dependencias del sistema para Laravel
# git y zip para composer, supervisor para correr queues (opcional), extensiones de PHP
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    zip \
    unzip \
    libpng-dev \
    libzip-dev \
    jpeg-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer (manejador de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear un usuario y grupo 'laravel' para no correr como root
RUN addgroup -g ${GID:-1000} laravel && \
    adduser -u ${UID:-1000} -G laravel -s /bin/sh -D laravel

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar los archivos de la aplicación
COPY --chown=laravel:laravel . /var/www

# Cambiar al usuario 'laravel'
USER laravel

# Exponer el puerto 9000 para FPM
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]