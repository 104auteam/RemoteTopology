#!/bin/bash
if [[ $1 == "build" ]]
then
docker-compose up -d --build #--force-recreate 
fi
docker-compose up -d