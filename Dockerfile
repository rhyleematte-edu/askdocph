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
    nginx \
    supervisor

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
RUN npm install && npm run production

# Permissions
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache
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

RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Supervisor config
RUN printf "[supervisord]\n\
nodaemon=true\n\
user=root\n\
logfile=/var/log/supervisor/supervisord.log\n\
pidfile=/var/run/supervisord.pid\n\
\n\
[program:php-fpm]\n\
command=php-fpm\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0\n\
\n\
[program:nginx]\n\
command=nginx -g \"daemon off;\"\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0\n" > /etc/supervisor/conf.d/supervisord.conf

# Verbose Start Script
RUN printf "#!/bin/sh\n\
set -ex\n\
echo \"--- STARTING DEPLOYMENT ---\"\n\
\n\
export PORT=\${PORT:-8080}\n\
echo \"Target Port: \$PORT\"\n\
\n\
# Replace port in all possible config locations\n\
sed -i \"s/8080/\$PORT/g\" /etc/nginx/sites-available/default\n\
sed -i \"s/8080/\$PORT/g\" /etc/nginx/sites-enabled/default || true\n\
\n\
# Test Nginx\n\
nginx -t\n\
\n\
# Background migrations\n\
(php artisan migrate --force || echo \"Migration failed\") &\n\
\n\
echo \"--- STARTING SUPERVISOR ---\"\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf\n" > /start.sh

RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
