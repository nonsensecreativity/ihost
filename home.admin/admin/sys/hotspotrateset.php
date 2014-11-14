<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/chilli/";
$orgname = "defaults";
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "defaults";

$oldratedown="HS_DEFBANDWIDTHMAXDOWN=" . $_POST['oldratedown'];
$oldrateup="HS_DEFBANDWIDTHMAXUP=" . $_POST['oldrateup'];

$ratedown="HS_DEFBANDWIDTHMAXDOWN=" . $_POST['ratedown'];          
$rateup="HS_DEFBANDWIDTHMAXUP=" . $_POST['rateup'];       


$oldratedown =  substr($oldratedown,0,strlen($oldratedown)-2);
$oldrateup =  substr($oldrateup,0,strlen($oldrateup)-2);

$str = "sudo sed 's/" . $oldratedown  . "/" . $ratedown   . "/g'  " . $orgpath . $orgname . " > " . $fpath . $fname . ".tmp";
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed 's/" . $oldrateup  . "/" . $rateup   . "/g'  " .  $fpath . $fname . ".tmp" . " > " .  $fpath . $fname;
//echo $str;
$output = shell_exec($str);  

$str = "sudo cp " .  $fpath . $fname  . "  " .  $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);  

echo "<br />";

echo "Done! <br />";

$str = "sudo  cat /etc/chilli/defaults | grep HS_DEFBANDWIDTHMAXDOWN=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$ratedown=$myArray[1];

$str = "sudo  cat /etc/chilli/defaults | grep HS_DEFBANDWIDTHMAXUP=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);  
$rateup=$myArray[1];

echo "<br />";
echo "Download Rate limit = " . $ratedown . "<br />";
echo "Upload Rate limit = " . $rateup . "<br />";


?> 
</body>

