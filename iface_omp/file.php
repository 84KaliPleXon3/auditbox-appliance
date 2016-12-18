#!/usr/bin/php

<?php
#$path = "/root/Documents/scripts-process-management/iface_omp/reports"; 
$path = "./reports"; 

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
echo $latest_filename;
// now $latest_filename contains the filename of the file that changed last

