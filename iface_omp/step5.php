<?php
if (PHP_SAPI != "cli") {
    exit;
}


function step5() {
	exec('omp -G', $output, $ret_var);
	
	foreach ($output as $line){
		echo $line . "\r\n";
	}

	//var_dump($output);

}

