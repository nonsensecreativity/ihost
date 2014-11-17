<?php

    $sql = "  insert into authsms set sms = '"  . $msg  . 
           "',  msgid = '" . $msg  .
           "',  mac = '" . $_GET['mac'] .
           "',  ip = '" . $_GET['ip'] .
           "',  phone = '" . $_POST['sphone'] .
           "',  token = '" . $token .
           "',  stat ='0',  rectime=now()";  
              
    $result = mysql_query($sql);       
    if (!$result) { // Error handling
        echo "send out msg failed"; 
    }
    else{
        mysql_free_result($result);
    }
?>

        
