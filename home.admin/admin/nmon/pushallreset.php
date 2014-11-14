<?php

$subnet = "172.16.0.0/16";

$proxyip = "172.16.0.1";
$proxyport = "3128";

$str = "sudo iptables -t nat -D PREROUTING -s  " . $subnet;
$str =  $str . " -p tcp --dport 80  -j DNAT --to  " . $proxyip . ":" . $proxyport;
//echo $str;
$output = shell_exec($str);

echo "<br />Reset all: Done!";


?>


