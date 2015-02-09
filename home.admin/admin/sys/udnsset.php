<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/";
$orgname = "resolv.dnsmasq.conf";  


$dns1 = str_replace(" ","",$_POST['dns1']);
$dns1 = str_replace("\n","",$dns1);

$dns2 = str_replace(" ","",$_POST['dns2']);
$dns2 = str_replace("\n","",$dns2);

$dns3 = str_replace(" ","",$_POST['dns3']);
$dns3 = str_replace("\n","",$dns3);

$strline1 = "nameserver "  . $dns1;
$strline2 = "nameserver "  . $dns2;
$strline3 = "nameserver "  . $dns3;


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
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$dns1 = str_replace("\n","",$myArray[1]);

$str = "sudo  head -2 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$dns2 = str_replace("\n","",$myArray[1]);

$str = "sudo  head -3 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$dns3 = str_replace("\n","",$myArray[1]);

echo "<br />DNS Servers: <br />";
echo "DNS1: " . $dns1 . "<br />"; 
echo "DNS2: " . $dns2 . "<br />"; 
echo "DNS3: " . $dns3 . "<br />"; 

?> 
</body>
</html>



