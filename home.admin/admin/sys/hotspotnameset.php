<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/hostapd/";
$orgname = "hostapd.conf";
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "hostapd.conf";

$oldssid="ssid=" . $_POST['oldssid'];
$oldchannel="channel=" . $_POST['oldchannel'];

$ssid="ssid=" . $_POST['ssid'];
$channel="channel=" . $_POST['channel'];

$oldssid =  substr($oldssid,0,strlen($oldssid)-2);
$oldchannel =  substr($oldchannel,0,strlen($oldchannel)-2);

$str = "sudo sed 's/" . $oldssid  . "/" . $ssid   . "/g'  " . $orgpath . $orgname . " > " . $fpath . $fname . ".tmp";
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed 's/" . $oldchannel  . "/" . $channel   . "/g'  " .  $fpath . $fname . ".tmp" . " > " .  $fpath . $fname;
//echo $str;
$output = shell_exec($str);  

$str = "sudo cp " .  $fpath . $fname  . "  " .  $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);  

echo "<br />";

echo "Done! <br />";

$str = "sudo  cat  /etc/hostapd/hostapd.conf  | grep ssid=";                
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$ssid=$myArray[1];          

$str = "sudo  cat  /etc/hostapd/hostapd.conf  | grep channel=";   
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);  
$channel=$myArray[1];    


echo "<br />";
echo "SSID = " . $ssid . "<br />";
echo "Channel = " . $channel . "<br />";


?> 
</body>

