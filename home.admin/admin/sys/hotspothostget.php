<html>
<title>cdns</title>
<body>
<?php

$str = "sudo  cat /etc/chilli/defaults | grep HS_UAMALLOW=";
//echo $str;
$output = shell_exec($str);
$output = str_replace(" ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$host=$myArray[1];
?> 

<form action="hotspothostset.php" method="POST">  
    <input type="hidden" name="oldhost" size="128" value="<?php echo $host;?>">
    <label>hosts allowed: </label><br />
    <label>eg: 192.168.1.1,192.168.0.0/24,192.168.2.1:80,www.autoinfo.org.cn </label><br />                   
    <input type="text" name="host" size="128" value="<?php echo $host; ?>">
    <br />  
    <input type="submit" value="set"/>  
</form>  
</body>

