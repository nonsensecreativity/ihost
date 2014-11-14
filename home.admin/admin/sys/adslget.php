<html>
<title>cdns</title>
<body>
<?php

$str = "sudo  cat /etc/ppp/peers/dsl-provider | grep 'user \"' ";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$user=str_replace("\"","",$myArray[1]);

$str = "sudo  cat /etc/ppp/pap-secrets | grep " . $user;
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode("*", $output);
$myArray = explode("\"", $myArray[1]);    
$passwd=$myArray[1];

?> 

<form action="adslset.php" method="POST">  
    <input type="hidden" name="olduser" size="32" value="<?php echo $user;?>">
    <input type="hidden" name="oldpasswd" size="16" value="<?php echo $passwd;?>">
    <label>User name: </label><br />
    <input type="text" name="user" size="32" value="<?php echo $user; ?>">
    <br /> 
    <label>Password: </label><br />
    <input type="password" name="passwd" size="16" value="<?php echo $passwd; ?>"> 
    <input type="submit" value="set"/>  
</form>  
</body>

