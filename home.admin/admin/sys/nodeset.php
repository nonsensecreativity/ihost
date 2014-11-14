<html>
<title>cdns</title>
<body>
<?php
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "node";
$orgpath = "/root/";
$orgname = "node";

$nodename = $_POST['nodename'];
$mac = $_POST['mac'];   
$ip = $_POST['ip'];   

$strline1 = "nodename="  . $nodename;
$strline2 = "nodemac="  . $mac;
$strline3 = "nodeip="  . $ip;


$str = "sudo sed -i '1s/.*/" . $strline1  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '2s/.*/" . $strline2  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '3s/.*/" . $strline3  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

echo "<br />";
echo "Done! <br />";

$str = "sudo  head -1 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$name = str_replace("\n","",$myArray[1]);

$str = "sudo  head -2 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$mac = str_replace("\n","",$myArray[1]);

$str = "sudo  head -3 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$ip = str_replace("\n","",$myArray[1]);

echo "nodename: " . $name . "<br />"; 
echo "nodemac: " . $mac . "<br />"; 
echo "nodeip: " . $ip . "<br />"; 

?> 
</body>
</html>



