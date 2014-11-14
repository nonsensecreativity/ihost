<html>
<title>usspoint</title>
<body>
<script type="text/javascript">
    function redirurl() {
        var frm = document.getElementById("go");
        frm.submit();
    }
</script>
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
    echo "未认证的用户  Uncertified User";
    echo "<br>";
    echo "<form name=\"go\" action=\"login.php\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"token\" value=\"" . $token . "\" />"; 
    }
else{
    echo "已认证的用户  Certified User";    
    echo "<br>";    
    echo "<form name=\"go\" action=\"complete.html\" method=\"get\">";
    }

include "orggetform.php"; 
echo "<input type =\"submit\" size=\"30\" value =\"继续 / Continue\">";                                             
echo "</form>";

mysql_free_result($result);

echo "<script>redirurl()</script>";

?>
</div>

</body>
</html>

