<html>
<title>pexc</title>
<body>
<?php
$dip=$_POST['destip'];
//echo $ifstr;
$dip = str_replace(";","",$dip);
$dip = str_replace("&","",$dip);
$dip = str_replace("|","",$dip);
$dip = str_replace("\\","",$dip);
$dip = str_replace(" ","",$dip);
echo "Ping : " . $dip;
$str = "sudo ping  " . $dip . "  -c 5 ";
//echo $str;
$output = shell_exec($str);
echo "<pre>$output</pre>";
?> 
</body>

