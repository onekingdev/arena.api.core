#!/usr/bin/env bash
if ps aux | grep -q "[/]usr/bin/supervisord"; then
    echo "supervisor is running"
else
    echo "start supervisor"
    sudo -E /usr/bin/python /usr/bin/supervisord -c /etc/supervisord.conf --pidfile /var/run/supervisord.pid
fi

sudo -E /usr/bin/supervisorctl restart all