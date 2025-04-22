# Gunakan image PHP dengan Apache
FROM php:7.4-apache

# Install dependensi
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Setel direktori kerja di dalam container
WORKDIR /var/www/html

# Salin file aplikasi ke dalam container
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependensi aplikasi menggunakan Composer
RUN composer install --no-dev --optimize-autoloader

# Setel hak akses file yang benar
RUN chown -R www-data:www-data /var/www/html

# Jalankan aplikasi menggunakan Apache
CMD ["apache2-foreground"]
