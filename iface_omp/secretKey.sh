#!/bin/bash
# ------------------------------------------------------------------
# [prophetnite] 
#          Create secretkey for server data exchange
#
# Dependency:
#      No Dependancies
# ------------------------------------------------------------------

if [ -s "./_config/secretKey" ]; then
        secretKey=`cat ./_config/secretKey`
else
        secretKey=$(blkid | grep `mount | grep ' / ' | grep '/dev' | cut -d' ' -f1 | sed 's/\/dev\///g' | sed 's/[1234567890]//g'` | sed 's/sd[a-z]/sda/g' | md5sum | cut -d' ' -f1)

        echo $secretKey > ./_config/secretKey
fi
