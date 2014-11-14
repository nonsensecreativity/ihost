<html>
<title>cdns</title>
<body>
<?php

$str = "sudo  cat  /root/node  | grep nodename=";  
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$nodename=$myArray[1];      

$str = "sudo  ifconfig eth0 | grep 'eth0'  |  sed 's/ \{2,\}/ /g'";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$mac=$myArray[4];

$str = "sudo  ifconfig eth0 | grep 'inet addr:'"; 
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode(':', $output);
$ipArray=explode(' ',$myArray[1]); 
$ip=$ipArray[0]

?> 

<form action="nodeset.php" method="POST">  
    <label>MAC: <?php echo $mac; ?></label><br />
    <input type="hidden" name="mac" size="20" value="<?php echo $mac; ?>"> 
    <br /> 
    <label>IP: <?php echo $ip; ?></label><br />      
    <input type="hidden" name="ip" size="20" value="<?php echo $ip; ?>">
    <br />  
    <label>Node name: </label><br />
    <input type="text" name="nodename" size="32" value="<?php echo $nodename; ?>">
    <br /> 
    <input type="submit" value="set"/>  
</form>  
</body>

