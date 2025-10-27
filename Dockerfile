FROM 961341543644.dkr.ecr.eu-central-1.amazonaws.com/production-eurobas-repository:latest
WORKDIR /var/www

COPY ./ /var/www
