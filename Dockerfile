FROM 961341543644.dkr.ecr.eu-central-1.amazonaws.com/production-eurobas-repository:latest
WORKDIR /var/www
RUN sed -i 's/memory_limit = 256M/memory_limit = 512M/' /usr/local/etc/php/php.ini
COPY ./ /var/www
