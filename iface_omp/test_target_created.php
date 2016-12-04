#!/usr/bin/php

<?php
$str='<create_target_response id="bde2fa6a-9d9f-4d89-81be-8e5357ba0231" status_text="OK, resource created" status="201"></create_target_response>';

echo $str . "\r\n\r\n";

preg_match('/id="(.*?)"/', $str, $matches);

var_dump($matches);

echo $matches[1];

?>


