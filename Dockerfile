# Imagen base con Apache y PHP 8.2
FROM php:8.2-apache

# Instalamos extensiones necesarias (MySQLi, PDO, etc.)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitamos mod_rewrite para Apache (útil en frameworks)
RUN a2enmod rewrite

# Copiamos el código del proyecto al contenedor
COPY . /var/www/html/mini-framework

# Establecemos el directorio de trabajo
WORKDIR /var/www/html/mini-framework

# Damos permisos a Apache
RUN chown -R www-data:www-data /var/www/html/mini-framework

# Exponemos el puerto 80
EXPOSE 80

RUN echo '<Directory /var/www/html/mini-framework>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/allowoverride.conf \
    && a2enconf allowoverride

