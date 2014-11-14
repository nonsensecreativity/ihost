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
if (!empty($_POST['mac'])){             
    $_POST['mac'] = str_replace(" ","",$_POST['mac']);  
    $_POST['mac'] = str_replace("%20","",$_POST['mac']);  
    $_POST['mac'] = str_replace("\t","",$_POST['mac']);
    if (strlen($_POST['mac']) > 30){ $_POST['mac'] = substr($_POST['mac'],0,30); }
    }       
if (!empty($_POST['cliid'])){  
    $_POST['cliid'] = str_replace(" ","",$_POST['cliid']);  
    $_POST['cliid'] = str_replace("%20","",$_POST['cliid']);  
    $_POST['cliid'] = str_replace("\t","",$_POST['cliid']);
    if (strlen($_POST['cliid']) > 30){ $_POST['cliid'] = substr($_POST['cliid'],0,30); }
    }
if (!empty($_POST['cliphone'])){ 
    $_POST['cliphone'] = str_replace(" ","",$_POST['cliphone']);  
    $_POST['cliphone'] = str_replace("%20","",$_POST['cliphone']);  
    $_POST['cliphone'] = str_replace("\t","",$_POST['cliphone']);
    if (strlen($_POST['cliphone']) > 30){ $_POST['cliphone'] = substr($_POST['cliphone'],0,30); }
    }
//

//
$sql = "  delete from authmac where mac = '" .  $_POST['mac'] . "'" ;                        
//echo $sql."<br />";
$result = mysql_query($sql);
echo $result."<br />";
$sql = "  delete from authclient where cid = '" . $_POST['cliid'] . "'";                        
//echo $sql."<br />";
$result = mysql_query($sql);
echo $result."<br />";

$sql = "  delete from authmac where cid = '" . $_POST['cliid'] . "'";                          
//echo $sql."<br />";
$result = mysql_query($sql);
echo $result."<br />";

$sql = "  delete from authclient where phone = '" . $_POST['cliphone'] . "'";                          
//echo $sql."<br />";
$result = mysql_query($sql);
echo $result."<br />";

$sql = "  delete from authmac where phone = '" . $_POST['cliphone'] . "'";                             
//echo $sql."<br />";
$result = mysql_query($sql);
echo $result."<br />";



mysql_free_result($result);



?>
</font>
</body>
</html>
