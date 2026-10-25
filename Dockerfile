FROM composer:2 AS vendor
WORKDIR /build
RUN composer create-project --no-dev --no-interaction --prefer-dist --no-scripts --ignore-platform-reqs laravel/laravel:^11.0 app
WORKDIR /build/app
COPY app ./app
COPY bootstrap/app.php ./bootstrap/app.php
COPY database ./database
COPY resources ./resources
COPY routes ./routes
RUN rm -f .env database/database.sqlite \
 && composer dump-autoload --optimize --no-dev --no-scripts

FROM php:8.3-apache
RUN docker-php-ext-install pdo_mysql opcache \
 && a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf
COPY docker/mpm.conf /etc/apache2/conf-enabled/zz-mpm.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY --from=vendor /build/app /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
