#!/usr/bin/env bash
set -eu

#
## shutdown and remove containers
docker-compose down -v

#
## cleanup
docker network prune -f
docker system prune --volumes -f
docker rmi $(docker images -q)
