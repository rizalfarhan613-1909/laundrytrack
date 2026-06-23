# 1. Gunakan image resmi PHP dengan Apache bawaan
FROM php:8.4-apache

# 2. Install dependensi sistem Linux yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    gnupg

# 3. Install Node.js untuk melakukan compile asset Tailwind/Vite
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# 4. Install ekstensi PHP yang diwajibkan oleh Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 5. Aktifkan mod_rewrite Apache agar routing web Laravel berfungsi
RUN a2enmod rewrite

# 6. Ubah Document Root Apache agar mengarah ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 7. Ambil Composer versi terbaru ke dalam container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 8. Tentukan folder kerja di dalam container
WORKDIR /var/www/html

# 9. Copy seluruh kode project Laravel kamu ke dalam container
COPY . .

# 10. Jalankan instalasi library PHP (Composer) untuk Production
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 11. Jalankan instalasi & build asset JavaScript/Tailwind CSS
RUN npm install && npm run build

# 12. Berikan izin akses folder (permission) agar Laravel bisa menulis log dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 13. Buka port 80 untuk akses web
EXPOSE 80