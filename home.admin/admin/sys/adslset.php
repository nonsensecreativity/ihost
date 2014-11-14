<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/ppp/peers/";
$orgname = "dsl-provider";
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "dsl-provider";

$olduser="user \"" . $_POST['olduser'];
$olduser =  substr($olduser,0,strlen($olduser)-2) . "\"";

$user="user \"" . $_POST['user'] . "\"";

$str = "sudo sed 's/" . $olduser  . "/" . $user   . "/g'  " . $orgpath . $orgname . " > " . $fpath . $fname;
#echo "<br />" . $str;
$output = shell_exec($str);
//echo "<br />";


$str = "sudo cp " .  $fpath . $fname  . "  " .  $orgpath . $orgname;
//echo $str;
$output = shell_exec($str); 

$orgpath = "/etc/ppp/";
$orgname = "pap-secrets";
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "pap-secrets";

$oldusername = "\"" . substr($_POST['olduser'],0,strlen($_POST['olduser'])-2) . "\"";
$username = "\"" . $_POST['user'] . "\"";
$str = "sudo sed 's/" . $oldusername  . "/" . $username   . "/g'  " . $orgpath . $orgname . " > " . $fpath . $fname . ".tmp";
#echo "<br />" . $str;
$output = shell_exec($str);
//echo "<br />";



$oldpasswd="\"" .  $_POST['oldpasswd'] . "\"";
//$oldpasswd =  substr($oldpasswd,0,strlen($oldpasswd)-2) . "\"";

$passwd="\"" . $_POST['passwd'] . "\"";

$str = "sudo sed 's/" . $oldpasswd  . "/" . $passwd   . "/g'  " . $fpath . $fname . ".tmp" . " > " . $fpath . $fname;
#echo "<br />" . $str;
$output = shell_exec($str);
//echo "<br />";


$str = "sudo cp " .  $fpath . $fname  . "  " .  $orgpath . $orgname;
//echo $str;
$output = shell_exec($str); 


echo "<br />";

echo "Done! <br />";

$str = "sudo  cat /etc/ppp/peers/dsl-provider | grep 'user \"' ";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$user=str_replace("\"","",$myArray[1]);

$str = "sudo  cat /etc/ppp/pap-secrets | grep " . $user;
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode("*", $output);
$myArray = explode("\"", $myArray[1]);    
$passwd=$myArray[1];


echo "<br />";
echo "User name :   " . $user . "<br />";
echo "Password :  " . $passwd . "<br />";


?> 
</body>

