FROM php:8.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    cron \
    iputils-ping \
    libxml2-dev \
    autoconf \
    zlib1g-dev

# Install latest Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_current.x | bash - && \
    apt-get install -y nodejs

# Clear apt cache
RUN apt clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql gd zip exif pcntl bcmath

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the cronjob definition file from the host to the container
# COPY cronjob /etc/cron.d/laravel-cron

# Copy the cronjob definition file to the container (cronjob file will be inside /etc/cron.d/)
RUN echo "* * * * * www-data /usr/local/bin/php /var/www/artisan schedule:run >> /var/log/cron.log 2>&1" > /etc/cron.d/laravel-cron

# Set correct permissions and create log file for cron
RUN chmod 0644 /etc/cron.d/laravel-cron && \
    touch /var/log/cron.log && \
    chown -f www-data:www-data /var/log/cron.log

# Create application user
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Start both cron and php-fpm
#CMD ["sh", "-c", "service cron start && tail -f /var/log/cron.log"]

# Expose PHP-FPM port
EXPOSE 9000
