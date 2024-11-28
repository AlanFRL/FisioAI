FROM php:8.2-apache

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Instalar dependencias de PHP
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Copiar el contenido del proyecto
COPY . /var/www/html/

# Establecer los permisos correctos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar Apache
COPY ./apache-config.conf /etc/apache2/sites-available/000-default.conf

# Exponer el puerto
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]
