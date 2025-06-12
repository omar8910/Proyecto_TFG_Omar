# Imagen base con PHP y Apache
FROM php:8.2-apache

# Instalar dependencias del sistema para Composer
RUN apt-get update && apt-get install -y unzip git curl

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Copiar el proyecto
COPY . /var/www/html/

# Establecer la carpeta por defecto
WORKDIR /var/www/html

# Instalar dependencias PHP
RUN composer install

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Cambiar DocumentRoot a 'public'
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80