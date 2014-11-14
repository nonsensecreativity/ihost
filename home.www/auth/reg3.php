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

//

//This is the directory where images will be saved 
//$target = "/images/"; 
$target = "/opt/id-images/"; 
$imgname = $_POST['cid'] . "-" . $_POST['phone'] . "-" . $_POST['token'] . "-" . strtolower(basename( $_FILES['image']['name'])); 
$target = $target . $imgname; 
$flag = 1;
//$pic=($_FILES['image']['name']);

//$image = addslashes(file_get_contents($_FILE['image']['tmp_name'])); //SQL Injection defence!
//echo $image . "<br \>";

$sql = "  update authclient set img = '" . $target . 
       "'  where cid ='" . $_POST['cid'] . 
       "'  and phone ='" . $_POST['phone'] .  
       "'  and token ='" . $_POST['token'] .        
       "'  and TIMESTAMPDIFF(SECOND, rectime, now()) < 300" ;
//echo $sql;
$result = mysql_query($sql);
if (!$result) { // Error handling
    $flag =0;
    echo "出现错误，请稍后再试<br />"; 
    echo "Sorry. Error detected.<br /> Please Try again a little later<br />"; 
    die();
}
mysql_free_result($result);

//echo $target . "<br \>"; 

//Writes the photo to the server 
if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) 
{ 

//Tells you if its all ok 

echo "文件 ". basename( $_FILES['image']['name']). "上传成功<br>"; 
echo "The file ". basename( $_FILES['image']['name']). "<br /> has been uploaded<br />"; 
} 
else {  
//Gives and error if its not
    $flag =0; 
    echo "上传出错，请稍后再试<br />";                                       
    echo "Sorry. Error uploading file.<br /> Please Try again a little later<br />"; 
    die();
} 

/*
$sql = "  select img from authclient "  . 
   "  where cid ='" . $_POST['cid'] . 
   "'  and phone ='" . $_POST['phone'] .  
   "'  and token ='" . $_POST['token'] .        
   "' order by rectime desc limit 1" ;
//echo $sql;
$result = mysql_query($sql);
if (!$result) { // Error handling
    $flag =0;
    echo "No imagename found!<br />"; 
}
else{
    $row = mysql_fetch_object($result);
    echo "<br \><img height=\"120\" width=\"160\" src=\"" . $row->img . "\">";
}
mysql_free_result($result);
*/

include "wsfdtget.php";

if ($response != "{\"data\":true}") { 
    $flag =0;
    echo "<br />证件识别失败<br />请重传证件照片<br />";
    echo "<br />Image chekck failed.<br /> Please reselect your image.<br />";
    die(); 
}


echo "<br /><br />";
//echo $flag . "<br />";


if ($flag == 1){
    // update local authlist
    include "lclmacset.php"; 

    // update local client list
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

