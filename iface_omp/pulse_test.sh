#!/bin/sh
#PulseCheck Shell Script
devID=`cat ./_config/deviceID`
pulseHost=`cat ./_config/pulseHost`
api=`cat ./_config/api`
check=`curl $pulseHost$devID.txt`

if [ "$check" = '1' ]; then
        echo "Task is waiting starting checkin"
        spawnTime=`date +%s`
        spawnTime=`expr $spawnTime + 15`
        screen -dmS `date +%s` ./DoCheck-nosleep.sh
        echo -n $spawnTime > ./_config/pulseTrigger
else
        echo "No task is waiting"
fi

