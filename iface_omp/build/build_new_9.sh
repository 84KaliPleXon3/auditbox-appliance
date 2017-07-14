#!/bin/bash
# ------------------------------------------------------------------
# [prophetnite] 
#          Setup new AuditBox Appliance 
#
#          Future script will create web console user and new  
#          API key for pushing data to remote web console server
#
# ------------------------------------------------------------------


#-----Audit 9000 ---------
#Ubuntu Server 16.04 standard install
#	- user accounts: galactica
#	- user password: galactica
#	- at package install screen, only 'standard system utilities'
if [ -f ./_config/deviceID ]
then
	echo "SYSTEM ALREADY CONFIGURED"
	exit
fi

echo Beginning New Aapliance setup...


sudo apt-get install xfce4
sudo apt-get install nmap firefox terminator

#-- install openvas ---------
sudo add-apt-repository ppa:mrazavi/openvas
sudo apt-get update
sudo apt-get install openvas9

sudo apt-get install sqlite3
sudo greenbone-nvt-sync
sudo greenbone-scapdata-sync
sudo greenbone-certdata-sync

#-- install openvas extras -- for reporting -------
sudo apt-get install texlive-latex-extra --no-install-recommends
sudo apt-get install libopenvas9-dev

#-- Start OpenVAS first time ------------
sudo service openvas-scanner restart
sudo service openvas-manager restart
sudo openvasmd --rebuild --progress

#-- Add user for OpenVAS --------------
openvasmd --create-user=admin --role=Admin
openvasmd --user=admin --new-password=galactica

#--------------------------------------
#install vmwaretools as nessesary
#apt-get update
#apt-get upgrade
#---------------------------------------

#setup ~/omp.config  OpenVAS authentication
#-------------------------------
echo '[Connection] 
host=localhost
port=9390 
username=admin
password=galactica' > ~/omp.config
#---------------------------------

#--------------------------------------
#install vmwaretools as nessesary
#apt-get update
#apt-get upgrade
#---------------------------------------

------As required-------- vbox guest additions--------------
sudo apt-get install build-essential linux-headers-$(uname -r)
sudo apt-get install virtualbox-guest-x11
-------------------------------------------------------------

