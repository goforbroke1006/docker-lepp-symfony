#!/usr/bin/env bash

docker-compose exec fpm composer create-project symfony/website-skeleton my_project
docker-compose exec fpm yarn add --dev babel-preset-react
docker-compose exec fpm yarn add react react-dom prop-types

echo 'Encore.enableReactPreset()' >> webpack.config.js;
