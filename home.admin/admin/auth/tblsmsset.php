<html>
<head>
<title>tblsms</title>
<META http-equiv="content-type" content="text/html; charset=utf-8"> 
</head>

<body>

<font size="2">
<?php

include "dbconn.php";

// sql injection inspection              
if (!empty($_POST['prefix'])){          
//    $_POST['prefix'] = str_replace(" ","",$_POST['prefix']);
//    $_POST['prefix'] = str_replace("%20","",$_POST['prefix']);
    $_POST['prefix'] = str_replace("\t","",$_POST['prefix']);
    if (strlen($_POST['prefix']) > 30){ $_POST['prefix'] = substr($_POST['prefix'],0,30); }
    }       
if (!empty($_POST['postfix'])){
//    $_POST['postfix'] = str_replace(" ","",$_POST['postfix']);
//    $_POST['postfix'] = str_replace("%20","",$_POST['postfix']);
    $_POST['postfix'] = str_replace("\t","",$_POST['postfix']);
    if (strlen($_POST['postfix']) > 30){ $_POST['postfix'] = substr($_POST['postfix'],0,30); }
    }

//

//$_POST['prefix'] = "[√‹¬Î Cert Code:]" ;
//$_POST['postfix'] = "[Supported by:…Ãµ¿]";

//
$sql = "  ALTER TABLE authsms ALTER prefix SET DEFAULT '" .  $_POST['prefix'] . "'" ;                        
//echo $sql."<br />";
$result = mysql_query($sql);
echo $result."<br />";
$sql = "  ALTER TABLE authsms ALTER postfix SET DEFAULT '" . $_POST['postfix'] . "'";                        
//echo $sql."<br />";
$result = mysql_query($sql);
echo $result."<br />";

mysql_free_result($result);



?>
</font>
</body>
</html>

