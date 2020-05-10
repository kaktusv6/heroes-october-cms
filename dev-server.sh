#!/bin/bash
set -e
export $(egrep -v '^#' .env-dev | xargs)
IP_LOCAL=$(ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1')

start() {
    nohup php artisan serve --port=${ARTISAN_SERVER_PORT} > ./dev-server.log 2>&1 &
    echo "development PHP web server started http://localhost:${ARTISAN_SERVER_PORT}"
    echo "Dashboard started http://localhost:${ARTISAN_SERVER_PORT}/backend"
    echo "log: dev-server.log"
    exit 0
}

startLocal() {
    nohup php artisan serve --host ${IP_LOCAL} --port=${ARTISAN_SERVER_PORT} > ./dev-server.log 2>&1 &
    echo "development PHP web server started http://${IP_LOCAL}:${ARTISAN_SERVER_PORT}"
    echo "Dashboard started http://${IP_LOCAL}:${ARTISAN_SERVER_PORT}/backend"
    echo "log: dev-server.log"
    exit 0
}

stop() {
    kill $(lsof -t -i:${ARTISAN_SERVER_PORT})
    echo "development PHP web server on port ${ARTISAN_SERVER_PORT} is stopped"
}

error_option() {
    echo "unknown option \"$1\"
known options:

start
stop

if no option, \"start\" will be used"
    exit 1
}

if [[ "$@" = *"stop"* ]]; then
    stop
elif [[ "$@" = *"start"* ]]; then
    start
elif [[ "$@" = *"local"* ]]; then
    startLocal
elif [[ "$@" = "" ]]; then
    start
else
    error_option $@
fi
