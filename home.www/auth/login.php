<html>
<title>usspoint</title>
<body>
<h3>Welcome to Hotspot</h3>
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
?>
<div style= 'font-size: 12px;'>
<form name="input" action="infochk.php" method="post"> 
如果您是已注册用户，<br />
请输入注册时所用的信息：<br />
If you had ever registerd before,<br />
please input your<br />
registration informations here:<br />
<br />
注册时所用证件号码：<br />
ID Nmuber used for registration :
<br />
<input type="text" size="30" name="cid" value="" /> 
<br /><br />
注册时所用手机号码：<br />
Phone number used for registration :
<br />
<input type="text" size="30" name="phone" value="" /> 
<br />
<input type="radio" name="scope" checked="checked" value="near" /> 最近一周使用过 / used in last week<br />
<input type="radio" name="scope" value="far" /> 最近一周未使用过 / not used in last week<br />
<input type="radio" name="scope" value="notsure" /> 不确定 / not sure<br />
<br />
<?php include "orgpostform.php"; ?>
<input type ="submit" value ="    提交 / Submit   ">
</form>
<?php
echo "<form name=\"goreg\" action=\"reg1.php\" method=\"post\">"; 
include "orgpostform.php";
echo "<input type=\"hidden\" name=\"token\" value=\"" . $_POST['token'] . "\" />";
echo "<input type =\"submit\" size=\"30\" value =\"在线申请上网凭证 &#13;&#10; Online Registration\">";
echo "</form>";
?>
<br />
注册过程需要上传证件照片<br />
请准备一张带头像和ID号的证件照片<br />
A photo of ID Card is need<br />
Please prepare a photo<br />
with your face and id number in it<br />
格式/format: jpg<br>
大小/size: < 1000k bytes
<br />
示例 / examples :<br />
<a href="sample.jpg">身份证</a>    
<a href="passport.jpg">Passport</a>
</div>
</body>
</html>

