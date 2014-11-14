<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/chilli/";
$orgname = "defaults";
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "defaults";

$olddns1="HS_DNS1=" . $_POST['olddns1'];
$olddns2="HS_DNS2=" . $_POST['olddns2'];

$dns1="HS_DNS1=" . $_POST['dns1'];
$dns2="HS_DNS2=" . $_POST['dns2'];

str_replace(" ","",$olddns1);
str_replace(" ","",$olddns2);
str_replace(" ","",$dns1);
str_replace(" ","",$dns2);

$olddns1 =  substr($olddns1,0,strlen($olddns1)-2);
$olddns2 =  substr($olddns2,0,strlen($olddns2)-2);

$str = "sudo sed 's/" . $olddns1  . "/" . $dns1   . "/g'  " . $orgpath . $orgname . " > " . $fpath . $fname . ".tmp";
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed 's/" . $olddns2  . "/" . $dns2   . "/g'  " .  $fpath . $fname . ".tmp" . " > " .  $fpath . $fname;
//echo $str;
$output = shell_exec($str);  

$str = "sudo cp " .  $fpath . $fname  . "  " .  $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);  

echo "<br />";

echo "Done! <br />";

$str = "sudo  cat /etc/chilli/defaults | grep HS_DNS1=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$dns1=$myArray[1];

$str = "sudo  cat /etc/chilli/defaults | grep HS_DNS2=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);  
$dns2=$myArray[1];

echo "<br />For wireless clients:<br />";
echo "DNS1 = " . $dns1 . "<br />";
echo "DNS2 = " . $dns2 . "<br />";


?> 
</body>

