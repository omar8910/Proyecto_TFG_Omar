FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libicu-dev \
    libsqlite3-dev \
    libmcrypt-dev \
    libreadline-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libmysqlclient-dev

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Copiar el proyecto
COPY . /var/www/html/

# Establecer la carpeta por defecto
WORKDIR /var/www/html

# Instalar dependencias PHP del proyecto
RUN composer install || true

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Cambiar el DocumentRoot a /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Asignar permisos adecuados
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80