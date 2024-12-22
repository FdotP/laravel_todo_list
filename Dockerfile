# Używamy oficjalnego obrazu PHP z Apache
FROM php:8.2-apache

# Instalujemy niezbędne zależności systemowe oraz rozszerzenia PHP
RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libxpm-dev \
        zip \
        git \
        libicu-dev \
        libxml2-dev \
        libssl-dev \
        libzip-dev \
        libonig-dev \
        supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-xpm \
    && docker-php-ext-install gd pdo pdo_mysql mbstring bcmath opcache intl xml zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean

# Ustawiamy katalog roboczy
WORKDIR /var/www/html

# Kopiujemy pliki aplikacji
COPY . ./

# Instalacja najnowszej wersji Node.js i npm (Node.js 18 lub 20)
RUN curl -fsSL https://deb.nodesource.com/setup_current.x | bash - && \
    apt-get install -y nodejs

# Sprawdzamy wersje Node.js i npm
RUN node -v && npm -v

# Ustawiamy publiczny katalog aplikacji jako domyślny katalog Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Włączamy mod_rewrite w Apache
RUN a2enmod rewrite

# Ustawiamy uprawnienia dla katalogów Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Instalujemy zależności projektu Laravel (PHP)
RUN rm -rf vendor composer.lock \
    && composer install --no-dev --optimize-autoloader --verbose

# Instalujemy zależności Node.js (npm)
RUN npm install

# Uruchamiamy npm run dev, aby skompilować zasoby frontendowe

# Dodajemy komendę do uruchomienia supervisora oraz npm run dev
CMD ["sh", "-c", "npm run dev & /usr/bin/supervisord"]

# Wystawiamy port 80
EXPOSE 80
