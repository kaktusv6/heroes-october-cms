#!/bin/bash
set -e
export $(egrep -v '^#' .env-dev | xargs)

start() {
    nohup php artisan serve --port=${ARTISAN_SERVER_PORT} > ./dev-server.log 2>&1 &
    echo "development PHP web server started http://localhost:${ARTISAN_SERVER_PORT}"
    echo "Dashboard started http://localhost:${ARTISAN_SERVER_PORT}/dashboard"
    echo "log: dev-server.log"
    exit 0
}

stop() {
    kill $(lsof -t -i:${ARTISAN_SERVER_PORT})
    echo "development PHP web server on port ${ARTISAN_SERVER_PORT} is stopped"
    exit 0
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
elif [[ "$@" = "" ]]; then
    start
else
    error_option $@
fi
