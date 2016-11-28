<?php
//echo $argv[0] . "-" . $argv[1] .  "-" . $argv[2] . "\n\r";

//RUN A SCAN
if (isset($argv[1]) && $argv[1] == "run"){
	echo "RUN---- \r\n";
	$cmd = "nmap -T4 -A -v 172.16.1.1/16";
	$outputfile = "nmap_output.txt";
	$pidfile = "nmap_pid.txt";

	$pid = exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));
	var_dump($pid);

//CHECK STATUS OF SCAN
}elseif (isset($argv[1]) && $argv[1] == "status"){
	echo "STATUS---- \r\n";
	function isRunning($pid){
	        try{
	                $result = shell_exec(sprintf("ps %d", $pid));
	                if(count(preg_split("/\n/", $result)) >  2){
	                        return true;
	                }
	        }catch(Exception $e){}

	        return false;

	}

	if (isRunning($argv[2])){
	        echo "Running: YES\r\n";

	}else {
	        echo "Running: NO\r\n";
	}


//LIST ALL SCANS PID'S
}elseif (isset($argv[1]) && $argv[1] =='list'){
	echo "LIST ---- \r\n";
	echo shell_exec("cat nmap_pid.txt");

}elseif (isset($argv[1]) && $argv[1] == 'killall'){

	$lines = file('nmap_pid.txt');

	// Loop through our array, show HTML source as HTML source; and line numbers too.
	foreach ($lines as $line_num => $line) {
	    exec('kill ' . $line);
	}
	exec('truncate -s 0 nmap_pid.txt');
}else {
	echo "No proper argument issued.\r\n";
}

?>
