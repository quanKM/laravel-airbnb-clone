#
# PHP Dependencies
#
FROM composer:latest as vendor

WORKDIR /app

COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
  --ignore-platform-reqs \
  --no-interaction \
  --no-plugins \
  --no-scripts \
  --prefer-dist

#
# Frontend
#
FROM node:alpine as frontend

WORKDIR /app

RUN mkdir -p /app/public

COPY package.json webpack.mix.js yarn.lock /app/
COPY resources/ /app/resources/

RUN yarn install && yarn production


##PHP

FROM sunasteriskrnd/php:fpm

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www


#COPY DEPENDENCY
COPY --from=vendor /app/vendor/ /var/www/vendor/
COPY --from=frontend /app/public/js/ /var/www/public/js/
COPY --from=frontend /app/public/css/ /var/www/public/css/
COPY --from=frontend /app/mix-manifest.json /var/www/mix-manifest.json


# Expose port 9000 and start php-fpm server
EXPOSE 9000


CMD ["php-fpm"]
