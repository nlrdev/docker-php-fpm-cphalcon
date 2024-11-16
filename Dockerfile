FROM php:8.2-fpm

RUN apt update -y && apt install -y \
apt-transport-https \ 
lsb-release \ 
ca-certificates \ 
wget \ 
git \
curl \ 
nano \ 
dialog \ 
net-tools \ 
openssl \
libpng-dev \
libonig-dev \
libxml2-dev \
libzip-dev \
zip \
unzip \ 
libpcre3-dev \ 
libcurl4-openssl-dev

RUN wget https://github.com/phalcon/cphalcon/releases/download/v5.8.0/phalcon-php8.2-nts-ubuntu-gcc-x64.zip && \
unzip phalcon-php8.2-nts-ubuntu-gcc-x64.zip && \ 
cp phalcon.so /usr/local/lib/php/extensions/no-debug-non-zts-20220829/ && \
echo 'extension=phalcon.so' > /usr/local/etc/php/conf.d/phalcon.ini

WORKDIR /usr/src/app
COPY ./src /usr/src/app
EXPOSE 9000
CMD ["php-fpm"]