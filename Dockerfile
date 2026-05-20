FROM 961341543644.dkr.ecr.eu-central-1.amazonaws.com/production-eurobas-repository:latest
WORKDIR /var/www
RUN sed -i 's/memory_limit = 256M/memory_limit = 512M/' /usr/local/etc/php/php.ini
RUN sed -i 's/php_admin_value\[memory_limit\] = 256M/php_admin_value[memory_limit] = 512M/' /usr/local/etc/php-fpm.d/app.conf
RUN sed -i 's/pm\.max_children = 30/pm.max_children = 15/' /usr/local/etc/php-fpm.d/app.conf
RUN sed -i 's/pm\.start_servers = 5/pm.start_servers = 3/' /usr/local/etc/php-fpm.d/app.conf
RUN sed -i 's/pm\.min_spare_servers = 3/pm.min_spare_servers = 2/' /usr/local/etc/php-fpm.d/app.conf
RUN sed -i 's/pm\.max_spare_servers = 10/pm.max_spare_servers = 5/' /usr/local/etc/php-fpm.d/app.conf
COPY ./ /var/www
