#!/usr/bin/env bash

docker-compose exec db createdb lepp_demo || true

sudo chmod -R 0777 ./