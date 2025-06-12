# Imagen base con PHP y Apache
FROM php:8.2-apache

# Copia todo el proyecto al contenedor
COPY . /var/www/html/

# Habilita mod_rewrite (útil si usas URLs amigables)
RUN a2enmod rewrite

# Configura permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configura Apache para servir desde la carpeta 'public'
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Expone el puerto 80
EXPOSE 80