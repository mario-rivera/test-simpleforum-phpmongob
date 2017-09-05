#!/bin/bash
PWD=$(pwd)
SCRIPT_WORKDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

BASENAME_LOWER=$(basename $SCRIPT_WORKDIR | tr '[:upper:]' '[:lower:]')

NETNAME=testnetwork

WEB_IMAGE_NAME=php-mongodb
WEB_CONTAINER_NAME=webapp
MONGO_DB_CONTAINER_NAME=mongo

create_network_ifnotexists(){
    # -z is if output is empty
    if [ -z "$(docker network ls | grep $1)" ]; then
        docker network create $1
        echo "Network $1 created"
    fi
}

install(){
    create_network_ifnotexists $NETNAME;
    
    build_image
    
    composer
    
    mongodb_up
    web_up
}

build_image(){
    
    docker build -t $WEB_IMAGE_NAME $SCRIPT_WORKDIR/docker/php
}

composer() {
    
    docker run -it --rm -v $SCRIPT_WORKDIR:/var/www $WEB_IMAGE_NAME bash -c "composer install"
}

mongodb_up() {
    
    docker run -d --network=$NETNAME --name $MONGO_DB_CONTAINER_NAME mongo:3.5
}

web_up(){
    
    docker run -d --name $WEB_CONTAINER_NAME -p 9999:80 --network=$NETNAME -v $SCRIPT_WORKDIR:/var/www $WEB_IMAGE_NAME
}

echo "Installing"
install