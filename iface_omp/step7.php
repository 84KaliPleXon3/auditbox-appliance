<?php
if (PHP_SAPI != "cli") {
    exit;
}

// GET REPORTS
function step7() {
	exec('echo NOT IMPLEMENTED', $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}

	//var_dump($output);

}

