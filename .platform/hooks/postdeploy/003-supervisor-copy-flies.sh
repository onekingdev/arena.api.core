#!/usr/bin/env bash
sudo cp -f /var/app/current/.config/supervisor/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf
sudo cp -f /var/app/current/.config/supervisor/laravel-isrc-worker.conf /etc/supervisor/conf.d/laravel-isrc-worker.conf
sudo cp -f /var/app/current/.config/supervisor/laravel-ledger-worker.conf /etc/supervisor/conf.d/laravel-ledger-worker.conf
sudo cp -f /var/app/current/.config/supervisor/laravel-upc-worker.conf /etc/supervisor/conf.d/laravel-upc-worker.conf
sudo cp -f /var/app/current/.config/supervisor/supervisord.conf /etc/supervisord.conf

sudo chmod 755 /etc/supervisor/conf.d/laravel-worker.conf
sudo chown root:root /etc/supervisor/conf.d/laravel-worker.conf

sudo chmod 755 /etc/supervisor/conf.d/laravel-isrc-worker.conf
sudo chown root:root /etc/supervisor/conf.d/laravel-isrc-worker.conf

sudo chmod 755 /etc/supervisor/conf.d/laravel-upc-worker.conf
sudo chown root:root /etc/supervisor/conf.d/laravel-upc-worker.conf

sudo chmod 755 /etc/supervisor/conf.d/laravel-ledger-worker.conf
sudo chown root:root /etc/supervisor/conf.d/laravel-ledger-worker.conf

sudo chmod 755 /etc/supervisor/conf.d/laravel-worker.conf
sudo chown root:root /etc/supervisor/conf.d/laravel-worker.conf