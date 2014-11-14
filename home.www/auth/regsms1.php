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
//

$token=rand();

echo "请检查您输入的信息：<br />";
echo "Please check your informations: <br />";
echo "证件号/ID Number：" . $_POST['cid'] . "<br />";
echo "手机号/Phone Number：" . $_POST['phone'] . "<br />";
echo "<br />";
echo "<br />";
echo "请确认手机号：<br />";
echo "Please confirm your phone number:<br />";
echo "<form name=\"regphoto\" action=\"regsms2.php\" method=\"POST\" >" . 
    "<input type=\"hidden\" name=\"token\" value=\"" .  $_POST['token'] . "\"/> " .
    "<input type=\"hidden\" name=\"cid\" value=\"" .  $_POST['cid'] . "\"/> " . 
    "<input type=\"hidden\" name=\"phone\" value=\"" . $_POST['phone'] . "\"/> " .  
    "<input type=\"hidden\" name=\"urltoken\" value=\"" . $_POST['token'] . "\"/> " .   
    "<input type=\"text\" size=\"30\" name=\"sphone\" value=\"" . $_POST['phone'] ."\" /><br /><br />";
include "orgpostform.php"; 
echo "<input type=\"submit\" name=\"button\" value=\"获取认证码&#13;&#10;Get Certification Code\" /></form>";

?>
</div>
</body>
</html>
