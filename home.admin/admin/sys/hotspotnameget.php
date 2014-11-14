<html>
<title>cdns</title>
<body>
<?php

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

?> 

<form action="hotspotnameset.php" method="POST">  
    <input type="hidden" name="oldssid" size="16" value="<?php echo $ssid;?>">
    <input type="hidden" name="oldchannel" size="16" value="<?php echo $channel;?>">
    <label>SSID: </label><br />
    <input type="text" name="ssid" size="16" value="<?php echo $ssid; ?>">
    <br /> 
    <label>Channel: </label><br />
    <input type="text" name="channel" size="16" value="<?php echo $channel; ?>"> 
    <input type="submit" value="set"/>  
</form>  
</body>

