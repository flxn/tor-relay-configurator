FROM php:7.4-apache

RUN apt-get update
RUN apt-get install python3 python3-pip -y
RUN python3 -m pip install stem

RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# set up cronjobs
RUN apt-get update && apt-get -y install cron
COPY cronjobs /etc/cron.d/torrelayco-cron
RUN chmod 0644 /etc/cron.d/torrelayco-cron
RUN crontab /etc/cron.d/torrelayco-cron
RUN touch /var/log/cron.log
