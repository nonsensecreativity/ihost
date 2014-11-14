<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/network/";
$orgname = "interfaces";

$address = str_replace(" ","",$_POST['address']);
$address = str_replace("\n","",$address);

$netmask = str_replace(" ","",$_POST['netmask']);
$netmask = str_replace("\n","",$netmask);

$network = str_replace(" ","",$_POST['network']);
$network = str_replace("\n","",$network);

$broadcast = str_replace(" ","",$_POST['broadcast']);
$broadcast = str_replace("\n","",$broadcast);

$gateway = str_replace(" ","",$_POST['gateway']);
$gateway = str_replace("\n","",$gateway);


$strline5 = "#iface eth0 inet dhcp";
$strline6 = "" . "iface eth0 inet static"; 
$strline7 = "" . "    " . "name Ethernet alias WAN card";
$strline8 = "" . "    " . "address " . $address;
$strline9 = "" . "    " . "netmask " . $netmask;
$strline10 = "" . "    " . "network " . $network;
$strline11 = "" . "    " . "broadcast " . $broadcast;
$strline12 = "" . "    " . "gateway " . $gateway;

$str = "sudo sed -i '5s/.*/" . $strline5  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '6s/.*/" . $strline6  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '7s/.*/" . $strline7  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '8s/.*/" . $strline8  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '9s/.*/" . $strline9  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '10s/.*/" . $strline10  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '11s/.*/" . $strline11  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '12s/.*/" . $strline12  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

echo "<br />";
echo "Done! <br />";

$str = "sudo  head -8 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$address = str_replace("\n","",$myArray[1]);

$str = "sudo  head -9 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$netmask = str_replace("\n","",$myArray[1]);

$str = "sudo  head -10 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$network = str_replace("\n","",$myArray[1]);

$str = "sudo  head -11 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$broadcast = str_replace("\n","",$myArray[1]);

$str = "sudo  head -12 " . $orgpath . $orgname . " | tail -1";
$output = shell_exec($str);
$output = str_replace("#","",$output);
$output = str_replace("    ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$gateway = str_replace("\n","",$myArray[1]);

echo "<br />Static IP is: <br />";
echo "ip address: " . $address . "<br />"; 
echo "netmask: " . $netmask . "<br />"; 
echo "network: " . $network . "<br />"; 
echo "broadcast: " . $broadcast . "<br />"; 
echo "gateway: " . $gateway . "<br />"; 

echo "<br />reboot to work with Static IP <br />";

?> 
</body>
</html>



