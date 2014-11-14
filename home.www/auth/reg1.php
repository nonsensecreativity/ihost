<html>
<title>usspoint</title>
<body>
<div style= 'font-size: 12px;'>
为了能够顺利开通您的账号，<br />
请提交真实有效的信息<br />
Please input correct<br />
informations<br />
注册前须先阅读“预知条款”<br />
Read terms & conditions first<br />
<a href="terms.html">预知条款/terms & conditions</a><br />
<form name="input" action="reg2.php" method="post">
请输入证件号码：<br />
Please input your<br />
Identification Card Number:<br />
<input type="text" size="30" name="cid" value="" /><br />
<br />
请输入手机号码：<br />
Phone number:<br />
<input type="text" size="30" name="phone" value="" /><br />
<br />
请选择首选语言：<br />
Select preferrd language:<br />
<select name="plan">
  <option value ="chinese">中文</option>
  <option value ="english">English</option>
</select>
<br /><br />
<?php

// sql injection inspection
include "orgchkpost.php";
if (!empty($_POST['token'])){
    $_POST['token'] = str_replace(" ","",$_POST['token']);
    $_POST['token'] = str_replace("%20","",$_POST['token']);
    $_POST['token'] = str_replace("\t","",$_POST['token']);
    if (strlen($_POST['token']) > 20){ $_POST['token'] = substr($_POST['token'],0,20); }
    }
//
include "orgpostform.php";
echo "<input type=\"hidden\" name=\"token\" value=\"" . $_POST['token'] . "\" />"; 
?>
<input type ="submit" value ="  提交 / Submit">
</form>

</body>
</html>
