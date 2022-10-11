#!/usr/bin/env bash
sudo cp -f /var/app/current/.config/crontab/laravel-cronjob  /etc/cron.d/laravel-crontjob
sudo chmod 644 /etc/cron.d/laravel-crontjob