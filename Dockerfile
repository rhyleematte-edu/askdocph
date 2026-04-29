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

# Patch broken ServeCommand at the exact line of the crash (if user runs artisan serve)
RUN sed -i 's/\$port + \$this->portOffset/(int)\$port + \$this->portOffset/g' vendor/laravel/framework/src/Illuminate/Foundation/Console/ServeCommand.php || true

RUN npm install && npm run production

# Create storage structure and fix permissions
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache
RUN php artisan storage:link || true

# Nginx config
RUN printf "server { \n\
    listen 8080; \n\
    root /app/public; \n\
    index index.php index.html; \n\
    location / { \n\
        try_files \$uri \$uri/ /index.php?\$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        include fastcgi_params; \n\
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name; \n\
    } \n\
}\n" > /etc/nginx/sites-available/default

# Enable the site (ensure symlink exists)
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Create robust start script
RUN printf "#!/bin/sh\n\
sed -i \"s/8080/\$PORT/g\" /etc/nginx/sites-available/default\n\
php artisan migrate --force\n\
php-fpm -D\n\
nginx -g \"daemon off;\"\n" > /start.sh

RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
