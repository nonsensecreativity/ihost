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
include "orgchkpost.php";
if (!empty($_POST['token'])){
    $_POST['token'] = str_replace(" ","",$_POST['token']);
    $_POST['token'] = str_replace("%20","",$_POST['token']);
    $_POST['token'] = str_replace("\t","",$_POST['token']);
    if (strlen($_POST['token']) > 20){ $_POST['token'] = substr($_POST['token'],0,20); }
    }
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
//
// generate certification code
$msg=rand(100000,999999);
//$msg="123456";
// put code in database
$sql = "  update authclient set sphone ='" . $_POST['sphone'] . 
       "', msg ='" .  $msg .
       "'  where cid ='" .  $_POST['cid'] .
       "'  and phone ='" . $_POST['phone'] .
       "'  and token =  '" . $_POST['token'] . "'";  
//echo $sql;
$result = mysql_query($sql);

//echo "<br />".$result;
mysql_free_result($result);

// send out code via sms
include "wssmsset.php";
/*
set_time_limit(0);
header("Content-Type: text/html; charset=GBK");
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
require_once SCRIPT_ROOT.'include/Client.php';
$gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';
$serialNumber = '0SDK-EMY-0130-XXXXX';
$password = '123456';
$sessionKey = '123456';
$connectTimeOut = 2;
$readTimeOut = 10;
$proxyhost = false;
$proxyport = false;
$proxyusername = false;
$proxypassword = false; 
$client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
//echo $client;
$client->setOutgoingEncoding("GBK");
$statusCode = $client->sendSMS(array('18833500052'),"test2");
echo $statusCode;
echo "<br />";
*/
//

// get code from user input
echo "请输入您收到的认证码:<br />";
echo "Please input your SMS certification code: <br />";

echo "<form name=\"regsms\" action=\"regsms3.php\" method=\"POST\">" . 
    "<input type=\"hidden\" name=\"token\" value=\"" .  $_POST['token'] . "\"/> " .
    "<input type=\"hidden\" name=\"cid\" value=\"" .  $_POST['cid'] . "\"/> " . 
    "<input type=\"hidden\" name=\"phone\" value=\"" . $_POST['phone'] . "\"/> " .  
    "<input type=\"hidden\" name=\"urltoken\" value=\"" . $_POST['urltoken'] . "\"/> " .   
    "<input type=\"hidden\" name=\"sphone\" value=\"" . $_POST['sphone'] . "\"/> " .   
    "<input type=\"text\" size=\"8\" name=\"chkmsg\"  value=\"\" /><br /><br />";
include "orgpostform.php"; 
echo "<input type=\"submit\" name=\"button\" value=\"提交/submit\" /></form>";
?>
</div>
</body>
</html>
