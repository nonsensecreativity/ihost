<?php
$sql = "  insert into authmac set mac = '"  . $_POST['mac']  .
       "',  ip ='" .  $_POST['ip'] .
       "',  cid ='" .  $_POST['cid'] .
       "',  phone ='" . $_POST['phone'] .              
       "',  token =  '" . $_POST['token'] . 
       "',  stat ='100',  rectime=now()";  
//echo $sql;
$result = mysql_query($sql);
if (!$result) { // Error handling
    echo "Warning: Auth list not updated!<br />"; 
}
mysql_free_result($result);
?>
