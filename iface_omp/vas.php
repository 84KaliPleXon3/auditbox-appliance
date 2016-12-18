#!/usr/bin/php
<?php

/**
* OpenVAS Management function library
*
* Long description for file (if any)...
*
* OpenVAS Management for AuditBox NESS
*
* @package    
* @author     Sebastian R. Usami <prophetnite>
* @copyright  2016 NewEngland Secure
* @license    
* @version    0.01b
* @link       http://github.com/prophetnite/auditbox
*/

if (PHP_SAPI != "cli") {
    exit;
}

/**
*
* Execution Options Menu for Functions
*
*/
if ($argc == 1 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
?>

This is a command line PHP script to manage OpenVAS scans.

  Usage:
  <?php echo $argv[0]; ?> <option>

  <option> can be any of the steps below to run and complete a scan of a system.

		1 - GET CONFIG TYPES 		- get_configs() 	
		2 - GET TARGETS			- get_targets()
		3 - GET TASKS			- get_tasks()
		4 - GET SCAN STATUS		- get_scan_status()

		5 - CREATE CONFIG TYPES		- create_config_type()
		6 - CREATE TARGET 		- create_target()
		7 - CREATE TASK 		- create_task()

		8 - START SCAN 			- start_scan()()

		9 - SETUP NEW AGENT 		- setup_agent()
			-VERIFY USER
			-VERIFY API KEY
			-CREATE TARGET
			-CREATE TASK
			-START FIRST SCAN


<?php
} else {

	// GET ALL SCAN CONFIGURATIONS
	if (isset($argv[1]) && $argv[1] == 1){
	    echo "Get all Configurations \r\n\r\n";
		get_configs();

	// GET TARGETS
	}elseif (isset($argv[1]) && $argv[1] == 2){
	    echo "Get all Targets \r\n\r\n";
		get_targets();

	// GET TASKS
	}elseif (isset($argv[1]) && $argv[1] == 3){
	    echo "Get all Tasks \r\n\r\n";
		get_tasks();

	// GET SCAN STATUS
	}elseif (isset($argv[1]) && $argv[1] == 4){
	    echo "Get Scan status \r\n\r\n";
		get_scan_status();

	// CREATE CONFIG TYPE
	}elseif (isset($argv[1]) && $argv[1] == 5){
	    echo "Create Config Type \r\n\r\n";
		create_config_type();

	// CREATE TARGET
	}elseif (isset($argv[1]) && $argv[1] == 6){
	    echo "Create Target \r\n\r\n";
		create_target('newenglandsecure.com','auditbox');

	// CREATE TASK
	}elseif (isset($argv[1]) && $argv[1] == 7){
	    echo "Create Task \r\n\r\n";

		if ( !isset($argv[2]) || !isset($argv[3]) || !isset($argv[4]) || !isset($argv[5])){
			echo "ERROR: Missing arguments \r\n\r\n";
			echo "Syntax: " . $argv[0] . " ScanName 'Scan Description' ConfigID TargetID\r\n\r\n";
			exit;
		}

	    $scanner_name='source_iface';
		$scanner_value='eth0';

		// $scan_name='Daily Scan';
		// $scan_comment='Daily scan for client 34232'; 
		// $config_id='74db13d6-7489-11df-91b9-002264764cea';
		// $target_id='b493b7a8-7489-11df-a3ec-002264764cea';

		$scan_name = $argv[2];
		$scan_comment = $argv[3];
		$config_id = $argv[4];
		$target_id = $argv[5];


		create_task($scan_name, $scan_comment, $config_id, $target_id);
		//create_task();
		
	// START SCAN
	}elseif (isset($argv[1]) && $argv[1] == 8){
	    echo "Start Scan \r\n\r\n";
		start_scan();

	// SETUP NEW APPLIANCE AGENT
	}elseif (isset($argv[1]) && $argv[1] == 9){
	    echo "Setup New Agent \r\n\r\n";
		setup_agent();

	} else {
		echo "Error in command syntax\r\n";
	}

}

//-----------------------------------------------------------------------



/**
*
* GET CONFIG TYPES
* @return string
*
*/
function get_configs() {
	exec('omp -g', $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}
}

/**
*
* GET TARGETS
* @return string
*
*/
function get_targets() {
	exec('omp -T', $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}
}


/**
*
* GET TASKS
* @return string
*
*/
function get_tasks() {
	echo "Not implemented as such \r\n";
	echo "Try get_scan_status()\r\n";	
}


/**
*
* GET STATUS OF SCANS
* @return string
*
*/
function get_scan_status() {
	exec('omp -G', $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}
}

/**
*
* CREATE CONFIG TYPE
*
* @todo CODE IT hurr durrr
*/
function create_config_type() {
	// NOT CODED YET
}



/**
*
* CREATE A NEW SCAN TARGET
*
* @param string $target_ip The target to be scanned
* @param string $target_name Simple name to identify target
* @return xml
*
*/
function create_target($target_ip, $target_name) {
	//$target_ip='localhost'; # target ip
	//$target_name='localhost2'; # target name
	
	$omp_cmd='omp --xml=\'
	<create_target>
	<name>'.$target_name.'</name>
	<hosts>'.$target_ip.'</hosts>
	</create_target>\'';

	exec($omp_cmd, $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}
}


/**
*
* CREATE A NEW TASK
*
* @param string $scan_name (required)
* @param string $scan_comment (required)
* @param string $config_id (required)
* @param string $target_id (required)
* @param string $scanner_name (optional)
* @param string $scanner_value (optional)
*
* @return xml
*
*/
function create_task($scan_name, $scan_comment, $config_id, $target_id, $scanner_name="", $scanner_value="") {
	$omp_cmd = 'omp --xml \'
	<create_task>
	        <name>'.$scan_name.'</name>
	        <preferences>
	                <preference>
	                        <scanner_name>'.$scanner_name.'</scanner_name>
	                        <value>'.$scanner_value.'</value>
	                </preference>
	        </preferences>
	        <config id="'.$config_id.'"/>
	        <target id="'.$target_id.'"/>
	</create_task>\'';

	exec($omp_cmd, $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}
}


/**
*
* START SCAN  FROM  TASK
*
* @param string $scanid OpenVAS ID of task
* @return xml
*
*/
function start_scan($scanid) {
	exec('omp -S' . $scanid, $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}
}


/**
*
* SETUP NEW AGENT FROM SCRATCH
* @todo Code it
*
*/
function setup_agent(){
	
}