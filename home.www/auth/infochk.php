<html>
<title>usspoint</title>
<body>

<div style= 'font-size: 12px;'>
<?php

include "dbconn.php";
// sql injection inspection              
if (!empty($_POST['cid'])){          
    $_POST['cid'] = str_replace(" ","",$_POST['cid']);
    $_POST['cid'] = str_replace("%20","",$_POST['cid']);
    $_POST['cid'] = str_replace("\t","",$_POST['cid']);
    if (strlen($_POST['cid']) > 30){ $_POST['cid'] = substr($_POST['cid'],0,30); }
    }       
if (!empty($_POST['phone'])){
    $_POST['phone'] = str_replace(" ","",$_POST['phone']);
    $_POST['phone'] = str_replace("%20","",$_POST['phone']);
    $_POST['phone'] = str_replace("\t","",$_POST['phone']);
    if (strlen($_POST['phone']) > 30){ $_POST['phone'] = substr($_POST['phone'],0,30); }
    }
if (!empty($_POST['plan'])){                  
    $_POST['plan'] = str_replace(" ","",$_POST['plan']);
    $_POST['plan'] = str_replace("%20","",$_POST['plan']);
    $_POST['plan'] = str_replace("\t","",$_POST['plan']);
    if (strlen($_POST['plan']) > 20){ $_POST['plan'] = substr($_POST['plan'],0,20); }
    }
include "orgchkpost.php";
if (!empty($_POST['token'])){
    $_POST['token'] = str_replace(" ","",$_POST['token']);               
    $_POST['token'] = str_replace("%20","",$_POST['token']);
    $_POST['token'] = str_replace("\t","",$_POST['token']);
    if (strlen($_POST['token']) > 20){ $_POST['token'] = substr($_POST['token'],0,20); }
    }
if (!empty($_POST['scope'])){
    $_POST['scope'] = str_replace(" ","",$_POST['scope']);               
    $_POST['scope'] = str_replace("%20","",$_POST['scope']);
    $_POST['scope'] = str_replace("\t","",$_POST['scope']);
    if (strlen($_POST['scope']) > 6){ $_POST['scope'] = substr($_POST['scope'],0,6); }
    }
//
$flag = 0;
$base = "";
//check local authclient table
$sql = "  select cid, phone, token from authclient " .                  
       "  where cid ='" .  $_POST['cid'] .
       "'  and (phone ='" . $_POST['phone'] . "'  or sphone ='" . $_POST['phone'] . 
       "')  and stat >= '100'" . 
       " order by id  desc limit 1";                        
//echo $sql."<br />";
$result = mysql_query($sql);
if ($result and mysql_num_rows($result)!=0) { 
    $flag = 1;  
    $row = mysql_fetch_object($result);
    $cid = $row->cid;   
    $phone = $row->phone; 
    $token = $row->token;    
    mysql_free_result($result);
}

if ($flag == 0) {
    //check central client list
    include "wsclichk.php";
}

if ($flag == 0) { 
    echo "未找到可匹配的记录，请返回重试<br />"; 
    echo "No record founded, please try again<br />"; 
}
else{
    //update local authlist
    $sql = "  insert into authmac set mac = '"  . $_POST['mac']  .
           "',  ip ='" .  $_POST['ip'] .
           "',  cid ='" .  $cid .
           "',  phone ='" .  $phone .              
           "',  token =  '" .  $token . 
           "',  base =  '" . $base . 
           "',  stat ='100',  rectime=now()";  
    //echo $sql;
    $result = mysql_query($sql);
    if (!$result) { // Error handling
        echo "Warning: update local authlist failed!<br />"; 
    }
    mysql_free_result($result);

    //update central authlist
    include "wsmacset1.php";

    // go next step
    echo "匹配成功  Record founded";      
    //echo "<form name=\"go\" action=\"complete.php\" method=\"post\">"; 
    echo "<form name=\"go\" action=\"complete.html\" method=\"get\">";
    include "orgpostform.php";          
    echo "<input type =\"submit\" size=\"30\" value =\"继续 / Continue\">";                                             
    echo "</form>";   

}

?>
</div>
</body>
</html>

