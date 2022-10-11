#!/usr/bin/env bash
file="/opt/elasticbeanstalk/deployment/env"
while IFS=: read -r f1
do
    export $f1
done <"$file"