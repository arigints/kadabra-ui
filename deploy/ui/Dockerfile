FROM wyveo/nginx-php-fpm:php72

WORKDIR /app

ADD --chown=nginx:nginx deploy/ui/default.conf /etc/nginx/conf.d/default.conf
COPY --chown=nginx:nginx . /app

RUN composer install --optimize-autoloader --no-dev

ADD deploy/ui/start.sh /app/start.sh

EXPOSE 80
CMD ["./start.sh"]