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

echo Beginning New Appliance setup...


sudo apt-get install -y xfce4
sudo apt-get install -y nmap firefox terminator

#-- install openvas ---------
sudo add-apt-repository ppa:mrazavi/openvas -y
sudo apt-get update
sudo apt-get install -y openvas9

sudo apt-get install -y sqlite3
sudo greenbone-nvt-sync
sudo greenbone-scapdata-sync
sudo greenbone-certdata-sync

#-- install openvas extras -- for reporting -------
sudo apt-get install -y texlive-latex-extra --no-install-recommends
sudo apt-get install -y libopenvas9-dev

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

------As required---- vmwaretools-------
#apt-get update
#apt-get upgrade
#---------------------------------------

------As required---- vbox guest additions-------------------
#sudo apt-get install -y build-essential linux-headers-$(uname -r)
#sudo apt-get install -y virtualbox-guest-x11
-------------------------------------------------------------

