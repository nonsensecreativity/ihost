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
if (!empty($_POST['token'])){
    $_POST['token'] = str_replace(" ","",$_POST['token']);
    $_POST['token'] = str_replace("%20","",$_POST['token']);
    $_POST['token'] = str_replace("\t","",$_POST['token']);
    if (strlen($_POST['token']) > 20){ $_POST['token'] = substr($_POST['token'],0,20); }
    }
include "orgchkpost.php";
if (!empty($_POST['urltoken'])){
    $_POST['urltoken'] = str_replace(" ","",$_POST['urltoken']);
    $_POST['urltoken'] = str_replace("%20","",$_POST['urltoken']);
    $_POST['urltoken'] = str_replace("\t","",$_POST['urltoken']);
    if (strlen($_POST['urltoken']) > 20){ $_POST['urltoken'] = substr($_POST['urltoken'],0,20); }
    }
if (!empty($_POST['sphone'])){
    $_POST['sphone'] = str_replace(" ","",$_POST['sphone']);
    $_POST['sphone'] = str_replace("%20","",$_POST['sphone']);
    $_POST['sphone'] = str_replace("\t","",$_POST['sphone']);
    if (strlen($_POST['sphone']) > 30){ $_POST['sphone'] = substr($_POST['sphone'],0,30); }
    }
if (!empty($_POST['chkmsg'])){
    $_POST['chkmsg'] = str_replace(" ","",$_POST['chkmsg']);
    $_POST['chkmsg'] = str_replace("%20","",$_POST['chkmsg']);
    $_POST['chkmsg'] = str_replace("\t","",$_POST['chkmsg']);
    if (strlen($_POST['chkmsg']) > 8){ $_POST['chkmsg'] = substr($_POST['chkmsg'],0,8); }
    }
$flag = 1;
//retrive msg from database
$sql = "  select msg from authclient " .  
       "  where cid ='" .  $_POST['cid'] .
       "'  and phone ='" . $_POST['phone'] .              
       "'  and token =  '" . $_POST['token'] .          
       "'  order by id desc limit 1" ;
//echo $sql;
$result = mysql_query($sql);
if (!$result or mysql_num_rows($result)==0){ 
//   echo "he"; 
   $flag=0;                 
    }
else{
    $row = mysql_fetch_object($result);
    $msg = $row->msg;
   }
mysql_free_result($result);

if ($msg != $_POST['chkmsg']){
//    echo "th";
    $flag = 0;
    }

echo "<br /><br />";
//echo $flag . "<br />";
if ($flag == 1){
    //update local maclist
    include "lclmacset.php"; 

    //update local client list
    include "lclcliset.php"; 


    //update central authlist
    include "wsmacset.php";

    //update central client list
    include "wscliset.php"; 
        
    // go next step
    echo "注册成功  Registration Completed";      
    //echo "<form name=\"go\" action=\"complete.php\" method=\"post\">"; 
    echo "<form name=\"go\" action=\"complete.html\" method=\"get\">";
    include "orgpostform.php";          
    echo "<input type =\"submit\" size=\"30\" value =\"继续 / Continue\">";                                             
    echo "</form>";    
    }
else{
    echo "发生错误，请稍后重试<br />Failed!<br /> Please try again later" ;
    }

?>
</div>
</body>
</html>

