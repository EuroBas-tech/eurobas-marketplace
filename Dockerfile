FROM 961341543644.dkr.ecr.eu-central-1.amazonaws.com/production-eurobas-repository:latest
WORKDIR /var/www

RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

COPY ./ /var/www
