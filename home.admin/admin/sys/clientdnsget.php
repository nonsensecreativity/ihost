<html>
<title>cdns</title>
<body>
<?php
//$str = "sudo  cp /etc/chilli/defaults  /opt/id-images/admin/tmpfile/";
//echo $str;
//$output = shell_exec($str);

//$str = "sudo  chown www-data:www-data  /opt/id-images/admin/tmpfile/defaults";
//echo $str;
//$output = shell_exec($str);


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

?> 

<form action="clientdnsset.php" method="POST">  
    <input type="hidden" name="olddns1" size="16" value="<?php echo $dns1;?>">
    <input type="hidden" name="olddns2" size="16" value="<?php echo $dns2;?>">
    <input type="text" name="dns1" size="16" value="<?php echo $dns1; ?>">
    <br /> 
    <input type="text" name="dns2" size="16" value="<?php echo $dns2; ?>"> 
    <input type="submit" value="set"/>  
</form>  
</body>

