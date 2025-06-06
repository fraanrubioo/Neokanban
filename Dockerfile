FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libonig-dev \
    libzip-dev \
    zip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Node.js y npm (si usas npm para tu frontend)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de la aplicación
COPY . .

# Instalar dependencias PHP (incluyendo dev, como Breeze o Pint)
RUN composer install

# Instalar dependencias de npm solo de producción (quita --omit=dev si estás en desarrollo)
RUN npm install --omit=dev

# Generar clave de app y migraciones necesarias (como sessions)
RUN php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force \
    && php artisan storage:link

# Configurar permisos
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Configurar Nginx
COPY ./nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

# Railway requiere que escuchemos en el puerto 8080
EXPOSE 8080

# Comando para iniciar ambos servicios
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
