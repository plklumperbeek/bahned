# Gebruik de officiële PHP-CLI image
FROM php:8.2-cli

# Installeer systeemvereisten en zip-extensie (nodig voor Composer)
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# Installeer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Stel de werkomgeving in
WORKDIR /app

# Kopieer projectbestanden
COPY . .

# Installeer PHP dependencies (zonder dev tools voor productie = --no-dev)
RUN composer install --dev --optimize-autoloader

# Exposeer de poort die Cloud Run verwacht
EXPOSE 8080

# Start de ingebouwde PHP webserver op de juiste poort
CMD ["php", "-S", "0.0.0.0:8080", "index.php"]
