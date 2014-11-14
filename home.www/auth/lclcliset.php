<?php
$sql = "  update authclient set stat ='100'" .                  
       "  where cid ='" .  $_POST['cid'] .
       "'  and phone ='" . $_POST['phone'] .              
       "'  and token =  '" . $_POST['token'] . "'";                        
//echo $sql;
$result = mysql_query($sql);
if (!$result) { // Error handling
    echo "Warning: Client table not updated!<br />"; 
}
//echo "<br />".$result; 
mysql_free_result($result);  
?>
