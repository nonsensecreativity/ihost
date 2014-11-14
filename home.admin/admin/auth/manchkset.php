<html>
<title>usspoint</title>
<body>
<div style= 'font-size: 12px;'>
<?php
include "dbconn.php";

//$recrow = $_POST['recrow'];
$rowid = $_POST['rowid'];
$chkflag = $_POST['chkflag'];

for ( $cnt = 0; $cnt < count($rowid); $cnt += 1) {
    $flist = $flist . $rowid[$cnt] . ",";
}
$flist = "(" . substr($flist,0,strlen($flist)-1) . ")";

for ( $cnt = 0; $cnt < count($chkflag); $cnt += 1) {
    $plist = $plist . $chkflag[$cnt] . ",";
}
if (strlen($plist)==0){$plist="'' ";}
$plist = "(" . substr($plist,0,strlen($plist)-1) . ")";
//echo $flist . "<br />";
//echo $plist . "<br />";

$sql = "  update authclient set manstat = round((manstat/2 + 10),0)"  . 
   "  where id in " . $plist ;
//echo $sql;
$result = mysql_query($sql);
if (!$result) { // Error handling
    echo "Update checked error!<br />";
    die(); 
}
$sql = "  update authclient set manstat = round((manstat/2 - 10),0)"  . 
   "  where id in " . $flist .
   "  and id not in " . $plist;
//echo $sql;  
$result = mysql_query($sql);
if (!$result) { // Error handling              
    echo "Update unchecked error!<br />"; 
    die(); 
}

mysql_free_result($result);

?>

Success!<br /><br />
<a href="manchkget.php">Next Page</a>
<br /><br />
<a href="manfrcget.php">Check Confilition</a>



</body>
</html>
