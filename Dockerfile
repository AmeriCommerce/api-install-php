FROM php:7.0.8-apache

# ENV http_proxy http://192.168.1.106:8888
# ENV https_proxy http://192.168.1.106:8888

RUN mkdir /var/www/html/{css,js,fonts}

COPY config/php.ini /usr/local/etc/php/
COPY src/ /var/www/html/
COPY bower_components/bootstrap/dist/css/ /var/www/html/css/
COPY bower_components/bootstrap/dist/js/ /var/www/html/js/
COPY bower_components/bootstrap/dist/fonts/ /var/www/html/fonts/
COPY bower_components/jquery/dist/ /var/www/html/js/