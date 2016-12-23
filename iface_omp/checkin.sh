#!/bin/bash
# ------------------------------------------------------------------
# [prophetnite] 
#          Starts checking loop in new screen
#
# Dependency:
#      No Dependancies
# ------------------------------------------------------------------



# determine the gateway interface nic#################
if [ "`uname`" = "GNU/kFreeBSD" ]; then
        gwNic=`netstat -r -f inet -n | grep ^default | awk '{print $6;}'`
else
        gwNic=$(route -n | grep '^0.0.0.0 ' | tail -n1 | awk '{print $8}')
fi

# if for some reason gateway interface can't be determined, use eth0
if [ "$gwNic" = '' ]; then
        gwNic='eth0'
fi
###################

 if [ "$checkinHost" = '' ]; then
         checkinHost='auditbox.newenglandsecure.com'
 fi

# echo "Updating checkin script (using $checkinHost)..."
 mac="`ifconfig $gwNic | grep HWaddr | awk '{print $5}'`"
# secretkey=`secretKey.sh`
# version=`cat ./_config/version`
# apikey=`cat ./_config/apikey`

## checking for scan tasks
curl --connect-timeout 45 --retry 5 "http://$checkinHost/api.php?r=1&k=$apikey&mac=$mac&version=$version"
heartbeat.sh



#curl --connect-timeout 45 --retry 5 -d "secretKey=$secretkey&mac=$mac&version=$version" https://$checkinHost/sarsCheckin.php > /scripts/pre-commands.sh
#curl --connect-timeout 45 --retry 5 http://$checkinHost/api.php?k=$apikey&mac=$mac&version=$version #> scripts/pre-commands.sh

# if [ "$?" != '0' ]; then
#         echo "Failed to communicate with checkin server, this is usually a result of network connectivity problems, exiting..."
#         exit
# fi

# echo "Checkin script updated, executing..."
# chmod +x ./scripts/pre-commands.sh
# . ./scripts/pre-commands.sh





# screen -list | grep "^Directory '/var/run/screen' must have mode" > /dev/null && chmod 777 /var/run/screen
# #Task System 77242
# heartbeatCurlPID=$(ps ax | grep -v 'grep' | grep -E 'SCREEN.*heartbeat.*heartbeat.sh' | awk '{print $1}' | head -n1 | xargs -n1 --no-run-if-empty ps --no-headers --ppid 2>/dev/null | grep 'sh$' | awk '{print $1}' | xargs -n1 --no-run-if-empty ps --no-headers --ppid 2>/dev/null | grep 'bash$' | awk '{print $1}' | xargs -n1 ps --no-headers --ppid 2>/dev/null | grep 'curl$' | awk '{print $1}')
# if [ "$heartbeatCurlPID" != '' ]; then
#         if [ "$(ps --no-headers -o etime $heartbeatCurlPID | grep -E -v '^[ \t]+0[0-9]:[0-9]{2}')" != '' ]; then
#                 echo "Heartbeat curl process has been running for more than 10 minutes, killing..."
#                 kill $heartbeatCurlPID
#         fi
# fi
# config_set pulseHost 'newenglandsecure.com/pulse/'
# if [ "$(screen -list | grep heartbeat | awk '{print $1}' | cut -d'.' -f2 | grep '^heartbeat$' > /dev/null && echo 'running')" != 'running' ]; then
#         config_set pulseTrigger 1
#         screen -d -m -S heartbeat sh ./scripts/heartbeat.sh
# fi
# if [ -z "`config_get pulseTrigger`" ]; then
#         config_set pulseTrigger 1
# fi
