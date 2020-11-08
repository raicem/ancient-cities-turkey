FROM nginx:1.16

RUN apt-get update -y
RUN apt-get install vim less curl -y

COPY default.conf /etc/nginx/conf.d/default.conf
