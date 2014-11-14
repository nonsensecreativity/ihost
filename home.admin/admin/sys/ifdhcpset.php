<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/network/";
$orgname = "interfaces";
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "interfaces";

$str = "sudo  head -8 /etc/network/interfaces | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$address=$myArray[1];

$str = "sudo  head -9 /etc/network/interfaces | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$netmask=$myArray[1];

$str = "sudo  head -10 /etc/network/interfaces | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$network =$myArray[1];

$str = "sudo  head -11 /etc/network/interfaces | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$broadcast =$myArray[1];

$str = "sudo  head -12 /etc/network/interfaces | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$gateway =$myArray[1];

$strline5 = "iface eth0 inet dhcp";
$strline6 = "#" . "iface eth0 inet static"; 
$strline7 = "#" . "    " . "name Ethernet alias WAN card";
$strline8 = "#" . "    " . "address " . $address;
$strline9 = "#" . "    " . "netmask " . $netmask;
$strline10 = "#" . "    " . "network " . $network;
$strline11 = "#" . "    " . "broadcast " . $broadcast;
$strline12 = "#" . "    " . "gateway " . $gateway;

$str = "sudo sed -i '5s/.*/" . $strline5  . "/' " . $orgpath . $orgname;
echo $str;
$output = shell_exec($str);
echo "<br />";

$str = "sudo sed -i '6s/.*/" . $strline6  . "/' " . $orgpath . $orgname;
echo $str;
$output = shell_exec($str);
echo "<br />";

$str = "sudo sed -i '7s/.*/" . $strline7  . "/' " . $orgpath . $orgname;
echo $str;
$output = shell_exec($str);
echo "<br />";

$str = "sudo sed -i '8s/.*/" . $strline8  . "/' " . $orgpath . $orgname;
echo $str;
$output = shell_exec($str);
echo "<br />";

$str = "sudo sed -i '9s/.*/" . $strline9  . "/' " . $orgpath . $orgname;
echo $str;
$output = shell_exec($str);
echo "<br />";

$str = "sudo sed -i '10s/.*/" . $strline10  . "/' " . $orgpath . $orgname;
echo $str;
$output = shell_exec($str);
echo "<br />";

$str = "sudo sed -i '11s/.*/" . $strline11  . "/' " . $orgpath . $orgname;
echo $str;
$output = shell_exec($str);
echo "<br />";

$str = "sudo sed -i '12s/.*/" . $strline12  . "/' " . $orgpath . $orgname;
echo $str;
$output = shell_exec($str);
echo "<br />";

/*
//$str = "sudo cp " .  $fpath . $fname  . "  " .  $orgpath . $orgname;
//echo $str;
//$output = shell_exec($str);  

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
*/

?> 
</body>


