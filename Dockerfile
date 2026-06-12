FROM --platform=linux/arm64 php:8.1-apache

RUN apt-get update && apt-get install -y libzip-dev zip && \
    docker-php-ext-install pdo pdo_mysql mysqli zip && \
    rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Document root trỏ vào /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

EXPOSE 80
