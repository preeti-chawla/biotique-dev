<?php

//$ip = $_SERVER['REMOTE_ADDR'];
$ip = '122.173.226.108';
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
echo '<pre>' ; print_r($details); // -> "Mountain View"

 ?>