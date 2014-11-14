<html>
<title>cdns</title>
<body>
<?php

$str = "sudo  cat /etc/chilli/defaults | grep HS_DEFSESSIONTIMEOUT=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$sessiontimeout=$myArray[1];

$str = "sudo  cat /etc/chilli/defaults | grep HS_DEFIDLETIMEOUT=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);  
$idletimeout=$myArray[1];

?> 

<form action="hotspottimeset.php" method="POST">  
    <input type="hidden" name="oldsessiontimeout" size="16" value="<?php echo $sessiontimeout;?>">
    <input type="hidden" name="oldidletimeout" size="16" value="<?php echo $idletimeout;?>">
    <label>Session Period(seconds): </label><br />
    <input type="text" name="sessiontimeout" size="16" value="<?php echo $sessiontimeout; ?>">
    <br /> 
    <label>Grace Period(seconds): </label><br />
    <input type="text" name="idletimeout" size="16" value="<?php echo $idletimeout; ?>"> 
    <input type="submit" value="set"/>  
</form>  
</body>

