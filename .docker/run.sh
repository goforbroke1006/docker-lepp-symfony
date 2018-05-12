#!/usr/bin/env bash


#docker-compose build

docker-compose down
docker-compose up -d

sleep 10 # wait when postgres warm up

docker-compose exec db createdb lepp_demo || true

#docker-compose exec fpm composer install

docker-compose exec fpm php bin/console doctrine:migrations:migrate --no-interaction
#docker-compose exec fpm yarn run encore dev