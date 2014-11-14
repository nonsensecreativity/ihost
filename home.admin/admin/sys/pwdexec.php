
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>usspoint admin</title>
<link rel="stylesheet" type="text/css" href="/admin/css/global.css" />
<style type="text/css">
#content h2 {
    font-size: 2em;
    margin-bottom: 15px;
}
#alertbox {
  margin: 15px 0 0 0;
}
</style>
</head>

<body>
<div id="header">
<h1>Maintenance</h1>                  
</div>

<div id="content">

<?php
$passwd1=$_POST['passwd1'];
$passwd2=$_POST['passwd2'];
if ($passwd1 != $passwd2){
    echo "Input doesn't match";
    die();
}
else{
    $htpasswdfile = "/opt/id-images/admin/.htpasswd";
    $str = "sudo  htpasswd -D  " . $htpasswdfile  . "  admin ";
    //echo $str;
    $output = shell_exec($str);
    //echo "<pre>$output</pre>";
 
    $str = "sudo  htpasswd -b  " . $htpasswdfile  . "  admin " . $passwd1;
    //echo $str;
    $output = shell_exec($str);
    //echo "<pre>$output</pre>";
   
}


?> 

</div>


</body>

</html>

