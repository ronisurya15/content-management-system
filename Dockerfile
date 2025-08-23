# BASE IMAGE
FROM php:8.2-fpm-alpine

# Instal Dependensi Yang Dibutuhkan PHP (Pacakge diinstall menggunakan apk atau Alpine Package Keeper)
RUN apk add --no-cache \
    bash \
    zip \
    unzip \
    git \
    curl \
    libpng \
    libpng-dev \
    libjpeg-turbo-dev \
    libxml2-dev \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    gd \
    exif \
    pcntl \
    bcmath \
    opcache \
    zip

# Salin File Composer Ke Image PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setting Working Directory (Disini Temen-temen Bisa Mengubah Working Directory Misalnya Jadi /htdocs)
WORKDIR /var/www/html

# Salin Semua File Laravel Ke Dalam Container (Semua File Akan Di Taruh Pada Folder /var/www/html)
COPY . .

# Ubah Permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose PORT (PORT 9000 Adalah Port Bawaan Dari PHP-FPM Jadi Temen-temen Jangan Merubahnya)
EXPOSE 9000

# Jalankan Perintah php-fpm Ketika Container Pertama Kali Berjalan
CMD ["php-fpm"]