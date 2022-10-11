#!/usr/bin/env bash

if [[ ! -f /usr/bin/supervisord ]]; then
    echo "install supervisor"
    sudo easy_install supervisor
else
    echo "supervisor already installed"
fi

if [[ ! -f /var/run/supervisor.sock ]]; then
    echo "create supervisor socket file"
    sudo touch /var/run/supervisor.sock
    sudo chmod 777 /var/run/supervisor.sock
else
    echo "supervisor socket already installed"
fi

if [[ ! -d /etc/supervisor ]]; then
    sudo mkdir /etc/supervisor
    echo "create supervisor directory"
fi

if [[ ! -d /etc/supervisor/conf.d ]]; then
    sudo mkdir /etc/supervisor/conf.d
    echo "create worker configs directory"
fi

if [[ ! -d /var/log/app/arena_api ]]; then
    sudo mkdir -p /var/log/app/arena_api
    sudo touch /var/log/app/arena_api/arena_api.err.log
    sudo touch /var/log/app/arena_api/arena_api.out.log
    echo "create supervisor log directory"
fi