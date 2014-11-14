<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/chilli/";
$orgname = "defaults";
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "defaults";

$oldhost="HS_UAMALLOW=" . $_POST['oldhost'];
$oldhost =  substr($oldhost,0,strlen($oldhost)-2);

$host="HS_UAMALLOW=" . $_POST['host'];

$str = "sudo sed 's|" . $oldhost  . "|" . $host   . "|g'  " . $orgpath . $orgname . " > " . $fpath . $fname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo cp " .  $fpath . $fname  . "  " .  $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);  

echo "<br />";

echo "Done! <br />";

$str = "sudo  cat /etc/chilli/defaults | grep HS_UAMALLOW=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$host=$myArray[1];

echo "<br />";
echo "Hosts allowed : " . $host . "<br />";


?> 
</body>

