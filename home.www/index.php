<html>
<title>usspoint</title>
<body>
<div style= 'font-size: 12px;'>
<?php
mysql_connect("localhost","root","rootatussp")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());

$sql = "  select count(id) as cnt from authclient "  . 
   "  where img <> '" . "" . 
   "'  and manstat ='" . "0" .        
   "'  and stat >='" . "0" .        
   "' " ;
//echo $sql;
$result = mysql_query($sql);
$recrow =  mysql_num_rows($result);

if (!$result or $recrow==0) { // Error handling
    $flag =0;
    echo "No record found!<br />"; 
}
else{
    $row = mysql_fetch_object($result);
    echo "<a href =\"manchkget.php\"> New Submissions : " . $row->cnt . " </a><br /><br />";  
}

$sql = "  select count(id) as cnt from authclient "  . 
   "  where img <> '" . "" . 
   "'  and manstat  between '" . "-5" .  "'  and '5" .
   "'  and manstat <> '0" .            
   "'  and stat >='" . "0" .        
   "' " ;
//echo $sql;
$result = mysql_query($sql);
$recrow =  mysql_num_rows($result);

if (!$result or $recrow==0) { // Error handling
    $flag =0;
    echo "No record found!<br />"; 
}
else{
    $row = mysql_fetch_object($result);
    echo "<a href =\"manfrcget.php\"> New Conflitions : " . $row->cnt . " </a><br /><br />";    
}
mysql_free_result($result);


?>
