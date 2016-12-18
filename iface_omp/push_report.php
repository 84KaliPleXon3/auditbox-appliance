#!/usr/bin/php
<?php

/**
* Push OMP XML Reports back to NESS server
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
* GET LATEST XML REPORT FILENAME
* @return string
*
*/
function getLatestReport($path){
	#$path = "./reports";

	$latest_ctime = 0;
	$latest_filename = '';

	$d = dir($path);
	while (false !== ($entry = $d->read())) {
		$filepath = "{$path}/{$entry}";
		// could do also other checks than just checking whether the entry is a file
		if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
			$latest_ctime = filectime($filepath);
			$latest_filename = $entry;
	  	}
	}	

	return $path .  "/" . $latest_filename;
	// now $latest_filename contains the filename of the file that changed last
}

$reportname = getLatestReport("./reports");


/**
*
* READ CONTENTS OF XML REPORT
*
*/
$myfile = fopen($reportname, "r") or die("Unable to open file!");
#$myfile = fopen("./reports/report_2016-12-18_03:03.xml", "r") or die("Unable to open file!");
$myreport=fread($myfile,filesize($reportname));


/**
*
* SEND REPORT TO SERVER
*
*/

$url = 'http://auditbox.newenglandsecure.com/api.php?r=3&k=6F1ED002AB5595859014EBF0951522D9';
$data = array('k' => '6F1ED002AB5595859014EBF0951522D9', 'task_id' => 'c9d0b718-7003-410e-b94b-f17KCUF5c942', 'report' => $myreport);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

var_dump($result);


?>
