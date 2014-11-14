<html>
<title>usspoint</title>
<body>

<div style= 'font-size: 12px;'>
<?php

include "dbconn.php";
// sql injection inspection

include "orgchkpost.php";
if (!empty($_POST['token'])){
    $_POST['token'] = str_replace(" ","",$_POST['token']);
    $_POST['token'] = str_replace("%20","",$_POST['token']);
    $_POST['token'] = str_replace("\t","",$_POST['token']);
    if (strlen($_POST['token']) > 20){ $_POST['token'] = substr($_POST['token'],0,20); }
    }
if (!empty($_POST['sphone'])){
    $_POST['sphone'] = str_replace(" ","",$_POST['sphone']);
    $_POST['sphone'] = str_replace("%20","",$_POST['sphone']);
    $_POST['sphone'] = str_replace("\t","",$_POST['sphone']);
    if (strlen($_POST['sphone']) > 30){ $_POST['sphone'] = substr($_POST['sphone'],0,30); }
    }
//

// put phonenumber  in database
$sql = "  update authsms set phone ='" . $_POST['sphone'] .
       "', rectime = now()" . 
       "  where token =  '" . $_POST['token'] . "'";  
//echo $sql;
$result = mysql_query($sql);

//echo "<br />".$result;
mysql_free_result($result);

//show cert code for test run
//retrive msg from database
$sql = "  select sms from authsms " .                
       "  where phone ='" . $_POST['sphone'] . 
       "'  and token =  '" . $_POST['token'] .          
       "'  order by id desc limit 1" ;
//echo $sql . "<br />";
$result = mysql_query($sql);
if (!$result or mysql_num_rows($result)==0){ 
   $flag=0;                 
    }
else{
    $row = mysql_fetch_object($result);
    $msg = $row->sms;
   }
mysql_free_result($result);
echo "test run : " .$msg . "<br />";
//---------------------


// get code from user input
echo "请输入您收到的认证码:<br />";
echo "Please input your SMS validation code: <br />";

echo "<form name=\"regsms\" action=\"ihostchksms.php\" method=\"POST\">" . 
    "<input type=\"hidden\" name=\"token\" value=\"" .  $_POST['token'] . "\"/> " .
    "<input type=\"hidden\" name=\"sphone\" value=\"" . $_POST['sphone'] . "\"/> " .   
    "<input type=\"text\" size=\"8\" name=\"chkmsg\"  value=\"\" /><br /><br />";
include "orgpostform.php"; 
echo "<input type=\"submit\" name=\"button\" value=\"提交/submit\" /></form>";
?>
</div>
</body>
</html>

