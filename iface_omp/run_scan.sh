#!/bin/bash
# ------------------------------------------------------------------
# [prophetnite] 
#		   OMP Scan and Report Extraction
#          Starts OMP Scan and pulls reports accordingly 
#          For use with AuditBox VAS Scripts
#
# Dependency:
#      AuditBox vas.php management
# ------------------------------------------------------------------
#start=$SECONDS

omp -T | grep auditbox |head -c 36 > target_id
targetid=$(cat target_id)

./vas.php 7 localscan MyLocalScanTest daba56c8-73ec-11df-a475-002264764cea $targetid
scanid=$(omp -G | grep localscan| head -c 36)

omp -S $scanid
omp -G | grep $scanid | grep Done > isdone

echo Beginning Scan . . . 

while [ ! -s isdone ];
do
	rm isdone
	sleep 3
	#duration=$((( SECONDS - start) / 60))
	echo Watching . . .  #$duration
	omp -G | grep $scanid | grep Done >  isdone
done

echo Scan Done . . .
echo Exporting Report

sleep 30

#THIS NEEDS TO BE FIXED, REPEAT CODE
scanid=$(omp -G | grep localscan| head -c 36)


#omp -i --xml='<get_tasks task_id="'$scanid'" details="1" />' | grep 'report id' > reportid
#omp -i --xml='<get_tasks task_id="'$scanid'" details="1" />' | grep 'report id' | cut -d'"' -f 2 | head -c 32 > reportid
omp -i --xml='<get_tasks task_id="'$scanid'" details="1" />' | grep 'report id' | cut -d'"' -f 2 | head -n 1 > reportid

#reportid=$(awk '{print substr($0,22,64)}' reportid)
reportid=$(cat reportid)

omp --get-report $reportid > ./reports/report_$(date +%Y-%m-%d_%H:%M).xml
omp -D $scanid

#omp -X '<delete_target target_id="'$targetid'"/>'

rm reportid target_id


