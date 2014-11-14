<html>
<title>cdns</title>
<body>
<?php

$str = "sudo  cat /etc/chilli/defaults | grep HS_UAMDOMAINS=";
//echo $str;
$output = shell_exec($str);
$output = str_replace("\"","",$output);
$output = str_replace(" ","",$output);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$domain=$myArray[1];
?> 

<form action="hotspotdomainset.php" method="POST">  
    <input type="hidden" name="olddomain" size="128" value="<?php echo $domain;?>">
    <label>domains allowed: </label><br />
    <label>eg: .paypal.com,.paypalobjects.com,.baidu.com </label><br />                   
    <input type="text" name="domain" size="128" value="<?php echo $domain; ?>">
    <br />  
    <input type="submit" value="set"/>  
</form>  
</body>

