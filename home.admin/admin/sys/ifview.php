<html>
<title>sif</title>
<body>
<?php
$str = "sudo ifconfig ";
//echo $str;
$output = shell_exec($str);
echo "<pre>$output</pre>";
?>
 
</body>

