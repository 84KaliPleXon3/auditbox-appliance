#!/usr/bin/php
<?php

include_once("step1.php");
include_once("step2.php");
include_once("step3.php");
include_once("step4.php");
include_once("step5.php");
include_once("step6.php");
include_once("step7.php");



if ($argc !=2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
?>

This is a command line PHP script to manage OpenVAS scans.

  Usage:
  <?php echo $argv[0]; ?> <option>

  <option> can be any of the steps below to run and complete a scan of a system.
	1 - Get CONFIG types
	2 - Get TARGETS
	3 - Get TASKS
	
	4 - Create TARGET
	5 - Create TASK from TARGET
	6 - start SCAN
	7 - get REPORTS

<?php
} else {

}
//if (file_exists('~/omp.config')) {
//    echo "The config file exists";
//} else {
//    echo "The config file does not exist";
//}


if (isset($argv[1]) && $argv[1] == 1){
        echo "STEP: 1 - Get all Configurations \r\n\r\n";
	step1();

//CHECK STATUS OF SCAN
}elseif (isset($argv[1]) && $argv[1] == 2){
        echo "STEP: 2 - Get all Targets \r\n\r\n";
	step2();

//CHECK STATUS OF SCAN
}elseif (isset($argv[1]) && $argv[1] == 3){
        echo "STEP: 3 - Get all Tasks \r\n\r\n";
	step3();

//CHECK STATUS OF SCAN
}elseif (isset($argv[1]) && $argv[1] == 4){
        echo "STEP: 4 - Create Target \r\n\r\n";
	step4();

//CHECK STATUS OF SCAN
}elseif (isset($argv[1]) && $argv[1] == 5){
        echo "STEP: 5 - Create Task from Target \r\n\r\n";
	step5();

//CHECK STATUS OF SCAN
}elseif (isset($argv[1]) && $argv[1] == 6){
        echo "STEP: 6 - Start Scan \r\n\r\n";
	step6();

//CHECK STATUS OF SCAN
}elseif (isset($argv[1]) && $argv[1] == 7){
        echo "STEP: 7 - Get Reports \r\n\r\n";
	step7();

}





?>


