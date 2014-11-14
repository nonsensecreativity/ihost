<html>
<title>cdns</title>
<body>
<?php

$orgpath = "/etc/network/";
$orgname = "interfaces";


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

?> 
Please input static ip parameters:<br />
<form action="sipset.php" method="POST">  
    <label>IP address: <br /></label>
    <input type="text" name="address" size="16" value="<?php echo $address; ?>">
    <label><br />Network mask: <br /></label>
    <input type="text" name="netmask" size="16" value="<?php echo $netmask; ?>"> 
    <label><br />Network: <br /></label>
    <input type="text" name="network" size="16" value="<?php echo $network; ?>">
    <label><br />Broadcast: <br /></label>
    <input type="text" name="broadcast" size="16" value="<?php echo $broadcast; ?>"> 
    <label><br />Gateway: <br /></label>
    <input type="text" name="gateway" size="16" value="<?php echo $gateway; ?>">
    <br />
    <input type="submit" value="set"/>  
</form>  
</body>
</html>


