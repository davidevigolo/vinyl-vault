FROM php:8.0-apache

# per installare le estensioni mysqli (classica) e pdo (più moderna)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# per abilitare il modulo rewrite di apache (spesso utile per URL puliti)
RUN a2enmod rewrite

# ensure upload directory exists and is writable by Apache
RUN mkdir -p /var/www/html/assets/uploaded_images \
	&& chown -R www-data:www-data /var/www/html/assets/uploaded_images \
	&& chmod -R 0775 /var/www/html/assets/uploaded_images
