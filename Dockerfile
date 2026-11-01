FROM php:8.3-apache

# Cloud Run sends traffic to the port in $PORT (default 8080)
ENV PORT=8080
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf \
 && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf

# curl extension is used to call the Translation API
RUN apt-get update && apt-get install -y --no-install-recommends libcurl4-openssl-dev \
 && docker-php-ext-install curl \
 && rm -rf /var/lib/apt/lists/*

COPY public/ /var/www/html/

EXPOSE 8080
