#!/bin/sh
#Heartbeat Shell Script
echo "Heartbeat Starting"
one=1
while [ 1 -eq 1 ]
do
        if test `date +%s` -gt `cat ./_config/pulseTrigger`
        then
                echo "Checking for task"
                bash pulse.sh
        else
                echo "Task run recently. Waiting.."
        fi
        sleep 3
done

