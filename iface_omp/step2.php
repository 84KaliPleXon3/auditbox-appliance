<?php
if (PHP_SAPI != "cli") {
    exit;
}

// GET TARGETS
function step2() {
	exec('omp -T', $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}

	//var_dump($output);

}

