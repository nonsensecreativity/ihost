<html>
<title>upstreamdns</title>
<body>
<?php

$orgpath = "/etc/";
$orgname = "resolv.dnsmasq.conf";  


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

?> 
Please input DNS servers:<br />
<form action="udnsset.php" method="POST">  
    <label>DNS1: <br /></label>
    <input type="text" name="dns1" size="16" value="<?php echo $dns1; ?>">
    <label><br />DNS2: <br /></label>
    <input type="text" name="dns2" size="16" value="<?php echo $dns2; ?>"> 
    <label><br />DNS3: <br /></label>
    <input type="text" name="dns3" size="16" value="<?php echo $dns3; ?>"> 
    <br />
    <input type="submit" value="set"/>  
</form>  
</body>
</html>


