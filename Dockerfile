FROM 961341543644.dkr.ecr.eu-central-1.amazonaws.com/production-eurobas-repository:latest
WORKDIR /var/www
RUN sed -i 's/memory_limit = 256M/memory_limit = 512M/' /usr/local/etc/php/php.ini
RUN sed -i 's/php_admin_value\[memory_limit\] = 256M/php_admin_value[memory_limit] = 512M/' /usr/local/etc/php-fpm.d/app.conf
 
COPY ./specifications/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

COPY ./ /var/www
