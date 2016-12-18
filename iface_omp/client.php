<h1>Save Report Test:</h1>

<?php

$myfile = fopen("./reports/report_2016-12-18_03:03.xml", "r") or die("Unable to open file!");
$myreport=fread($myfile,filesize("./reports/report_2016-12-18_03:03.xml"));

$url = 'http://auditbox.newenglandsecure.com/api.php?r=3&k=6F1ED002AB5595859014EBF0951522D9';
$data = array('k' => '6F1ED002AB5595859014EBF0951522D9', 'task_id' => 'c9d0b718-7003-410e-b94b-f1557425c942', 'report' => $myreport);

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
