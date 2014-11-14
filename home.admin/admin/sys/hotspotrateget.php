<html>
<title>cdns</title>
<body>
<?php

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

?> 

<form action="hotspotrateset.php" method="POST">  
    <input type="hidden" name="oldratedown" size="16" value="<?php echo $ratedown;?>">
    <input type="hidden" name="oldrateup" size="16" value="<?php echo $rateup;?>">
    <label>Download Rate Limit(bps): </label><br />
    <input type="text" name="ratedown" size="16" value="<?php echo $ratedown; ?>">
    <br /> 
    <label>Upload rate Limit(bps): </label><br />
    <input type="text" name="rateup" size="16" value="<?php echo $rateup; ?>"> 
    <input type="submit" value="set"/>  
</form>  
</body>

