FROM 961341543644.dkr.ecr.eu-central-1.amazonaws.com/production-eurobas-repository:latest
WORKDIR /var/www

RUN sed -i 's/memory_limit = 256M/memory_limit = 512M/' /usr/local/etc/php/php.ini
RUN sed -i 's/php_admin_value\[memory_limit\] = 256M/php_admin_value[memory_limit] = 512M/' /usr/local/etc/php-fpm.d/app.conf
COPY ./specifications/php-fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./specifications/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

COPY ./ /var/www

# Change all SVG icons color from black/gray to primary blue (#3b82f6) during build
RUN find /var/www/resources/themes/theme_aster/public/assets/img/svg/ -name "*.svg" -type f \
    -exec sed -i -e 's/#000000/#3b82f6/gI' -e 's/fill="black"/fill="#3b82f6"/gI' -e 's/#808080/#3b82f6/gI' -e 's/#666666/#3b82f6/gI' {} +
