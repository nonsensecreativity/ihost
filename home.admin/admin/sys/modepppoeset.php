<html>
<title>mode set</title>
<body>
<?php
$str = "sudo  bash  /root/modepppoe.sh";
//echo $str;
$output = shell_exec($str);

echo "<br />Done!<br />Wlan, pppoe";

?> 
</body>

