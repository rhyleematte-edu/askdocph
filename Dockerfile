FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    nginx

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts
# Patch broken ServeCommand
RUN sed -i 's/(int) $this->port()/(int) $this->port() + 0/g' vendor/laravel/framework/src/Illuminate/Foundation/Console/ServeCommand.php || true

RUN npm install && npm run production

# Create storage structure and fix permissions
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache
RUN php artisan storage:link

# Nginx config
RUN echo 'server { \n\
    listen 8080; \n\
    root /app/public; \n\
    index index.php index.html; \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        include fastcgi_params; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
    } \n\
}' > /etc/nginx/sites-available/default

# Start script
RUN echo '#!/bin/sh \n\
php artisan migrate --force \n\
php-fpm -D \n\
nginx -g "daemon off;"' > /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
