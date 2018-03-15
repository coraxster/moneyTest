FROM nginx
MAINTAINER Dmitry Kuzmin rockwith@me.com

COPY nginx.template /etc/nginx/conf.d/

CMD envsubst '$$NGINX_HOST $$NGINX_PORT $$FPM_HOST $$FPM_PORT' < /etc/nginx/conf.d/nginx.template > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'