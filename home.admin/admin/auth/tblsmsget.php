<html>
<head>
<title>tblsms</title>
<META http-equiv="content-type" content="text/html; charset=utf-8"> 
</head>
<body>
<?php
include "dbconn.php";
$sql = "  select default(prefix) as prefix, default(postfix) as postfix  from authsms limit 1" ;                        
$result = mysql_query($sql);
$row = mysql_fetch_object($result);
?>

<font size="2">
<form action="tblsmsset.php" method="POST">  
    <br />Prefix of SMS: <br />
    <input type="text" size="30" name="prefix" value="<?php echo $row->prefix; ?>" />
    <br />Postfix of SMS: <br />
    <input type="text" size="30" name="postfix" value="<?php echo $row->postfix; ?>" />
    <input type="submit" value="Set" />  
</form> 
</font>
<?php mysql_free_result($result);  ?>
</body>
</html>

