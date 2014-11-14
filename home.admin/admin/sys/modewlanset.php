<html>
<title>mode set</title>
<body>
<?php
$str = "sudo  bash  /root/modewlan.sh";
//echo $str;
$output = shell_exec($str);
$str = "sudo  bash  /root/iptab.sh";
$output = shell_exec($str);

echo "<br />Done!<br />Wlan, No pppoe";


?> 
</body>

