FROM nginx:stable-alpine

ENV NGINXUSER=qode
ENV NGINXGROUP=qode

RUN mkdir -p /var/www/html/public

ADD ./nginx/default.conf /etc/nginx/conf.d/default.nginx

RUN sed -i "s/user www-data/user ${NGINXUSER}/g" /etc/nginx/nginx.conf

RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}