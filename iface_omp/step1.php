<?php
if (PHP_SAPI != "cli") {
    exit;
}

// GET CONFIG TYPES
function step1() {
	exec('omp -g', $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}

	//var_dump($output);

}

