<html>
<title>usspoint</title>
<body>

<div style= 'font-size: 12px;'>
<?php

include "dbconn.php";

$flag = 1;
//retrive msg from database
$sql = "  select sms from authsms " .  
       "  where mac ='" . $_POST['mac'] .
       "'  and  ip = '" . $_POST['ip'] .              
       "'  and  phone = '" . $_POST['sphone'] .
       "'  and token =  '" . $_POST['token'] .          
       "'  order by id desc limit 1" ;
//echo $sql;
$result = mysql_query($sql);
if (!$result or mysql_num_rows($result)==0){ 
   $flag=0;                 
    }
else{
    $row = mysql_fetch_object($result);
    $msg = $row->sms;
   }
mysql_free_result($result);

if ($msg != $_POST['chkmsg']){
    $flag = 0;
    }
    
if ($flag == 1){
    //retrive url from database    
    $sql = "  select orgurl from authmacip " .              
           "  where token =  '" . $_POST['token'] .          
           "'  order by id desc limit 1" ;
    //echo $sql;
    $result = mysql_query($sql);
    if (!$result or mysql_num_rows($result)==0){ 
       $flag=0;                 
        }
    else{
        $row = mysql_fetch_object($result);
        $orgurl = $row->orgurl;
        //echo $orgurl;
        }
    mysql_free_result($result);
    }

echo "<br /><br />";
//echo $flag . "<br />";
if ($flag == 1){
    //update local maclist
    include "lclmacset.php"; 

    //update central authlist
    include "wsmacset.php";

    //update central client list
    include "wscliset.php"; 
        
    // go next step
    echo "<a href=\"" . $orgurl . "\"> 注册成功, 点击此处继续 <br />Registration Completed,<br /> click here to continue </a>"; 
    header("Location: " .  $orgurl );
    die();    
    }
else{
    echo "发生错误，请稍后重试<br />Error! <br />Please try again later." ;
    }

?>
</div>
</body>
</html>

