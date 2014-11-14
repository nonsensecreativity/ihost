<html>
<title>usspoint</title>
<body>
<div style= 'font-size: 12px;'>
<?php

include "dbconn.php";
$url_orign = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// sql injection inspection
include "orgchkget.php";
//

$sql = "  select token from  authmacip where mac = '" . $_GET['mac'] .  
       "'  and  ip ='" . $_GET['ip'] . 
       "'  and  called ='" . $_GET['called'] . 
       "'  and  userurl ='" . $_GET['userurl'] .
       "'  and TIMESTAMPDIFF(SECOND, rectime, now()) < 180 " . 
       "   order by rectime desc limit 1" ;
//echo $sql;
$result = mysql_query($sql);

if (mysql_num_rows($result)==0){ 
    mysql_free_result($result);
    $token = rand();
    $sql = "  insert into authmacip set mac = '" . $_GET['mac'] . 
       "',  ip ='" . $_GET['ip'] . 
       "',  called ='" . $_GET['called'] . 
       "',  srcip ='" . $_SERVER ['HTTP_HOST'] .
       "',  procid ='" . "portal" . 
       "',  userurl ='" . $_GET['userurl'] .
       "',  orgurl ='" . $url_orign .
       "',  token ='" . $token .         
       "', rectime = now()" ;
//    echo $sql;
    $result = mysql_query($sql);
//    mysql_free_result($result);
    }
else{
    $row = mysql_fetch_object($result);
    $token = $row->token;
    mysql_free_result($result);
    }

$auth = 0;

$sql = "  select id from authmac where mac = '" . $_GET['mac'] . "'";
$result = mysql_query($sql);
if (mysql_num_rows($result)!=0){
   $auth = 1;
   }

if ($auth == 0){
    //check central authlist
    include "wsmacchk.php";
    }
if ($auth == 0){ 

    $msg=rand(100000,999999);
    //$msg="123456";
    // input code in table authsms
    include "wssmsset.php";

    echo "<br />";    
    echo "未接通Internet<br />NOT Connected to the Internet yet";
    echo "<form name=\"regsms\" action=\"ihostgetsms.php\" method=\"POST\" >" ;
    echo "<input type=\"hidden\" name=\"token\" value=\"" . $token . "\" />"; 
    echo "请输入接收短信的手机号:<br /> Please input your phone number<br /> to receive a certification code:<br />";
    echo "<input type=\"text\" size=\"30\" name=\"sphone\" value=\"\" /><br /><br />";
    include "orggetform.php"; 
    echo "<input type=\"submit\" name=\"button\" value=\"获取短信认证码&#13;&#10;Get SMS Certification Code\" /></form>";
 
    }
else{

    echo "<div id=\"MyChilli\">";
    echo "<script id=\"chillijs\" src=\"ussp.js\"></script>";
    echo "</div>";
    echo "<br />";    
    echo "已为您接通Internet<br />Connected to the Internet";
    echo "<br>";    
    echo "<br />";  
    echo "<a href=\"" . $_GET['userurl'] . "\"> 点击此处继续您的Internet之旅<br />Please Click to Continue<br /> your Internet surfing </a>";
    }



mysql_free_result($result);


?>
</div>

</body>
</html>


