<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/chilli/";
$orgname = "defaults";
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "defaults";

$oldsessiontimeout="HS_DEFSESSIONTIMEOUT=" . $_POST['oldsessiontimeout'];
$oldidletimeout="HS_DEFIDLETIMEOUT=" . $_POST['oldidletimeout'];

$sessiontimeout="HS_DEFSESSIONTIMEOUT=" . $_POST['sessiontimeout'];
$idletimeout="HS_DEFIDLETIMEOUT=" . $_POST['idletimeout'];

$oldsessiontimeout =  substr($oldsessiontimeout,0,strlen($oldsessiontimeout)-2);
$oldidletimeout =  substr($oldidletimeout,0,strlen($oldidletimeout)-2);

$str = "sudo sed 's/" . $oldsessiontimeout  . "/" . $sessiontimeout   . "/g'  " . $orgpath . $orgname . " > " . $fpath . $fname . ".tmp";
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed 's/" . $oldidletimeout  . "/" . $idletimeout   . "/g'  " .  $fpath . $fname . ".tmp" . " > " .  $fpath . $fname;
//echo $str;
$output = shell_exec($str);  

$str = "sudo cp " .  $fpath . $fname  . "  " .  $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);  

echo "<br />";

echo "Done! <br />";

$str = "sudo  cat /etc/chilli/defaults | grep HS_DEFSESSIONTIMEOUT=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$sessiontimeout=$myArray[1];

$str = "sudo  cat /etc/chilli/defaults | grep HS_DEFIDLETIMEOUT=30";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);  
$idletimeout=$myArray[1];

echo "<br />";
echo "Session Period = " . $sessiontimeout . "<br />";
echo "Grace Period = " . $idletimeout . "<br />";


?> 
</body>

