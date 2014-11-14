<html>
<title>usspoint</title>
<body>
<div style= 'font-size: 12px;'>
<?php
include "dbconn.php";

$sql = "  select id,img from authclient "  . 
   "  where img <> '" . "" . 
   "'  and stat >='" . "0" .        
   "' order by rectime desc limit 20" ;
//echo $sql;
$result = mysql_query($sql);
$recrow =  mysql_num_rows($result);

if (!$result or $recrow==0) { // Error handling
    $flag =0;
    echo "No record found!<br />"; 
}

else{
    echo "<form name=\"go\" action=\"\" method=\"post\">"; 
//    $row = mysql_fetch_object($result);

    echo "<table border='0'>";
    while ($row = mysql_fetch_object($result)) {
        echo "<tr>";
        echo "<td><input type =\"hidden\" name=\"rowid[]\" value =\"" .  $row->id  . "\"></td>";
        echo "<td><img height=\"90\" width=\"120\" src=\"" . str_replace("/opt/id-images","",$row->img) . "\"></td>";
        echo "</tr>";
    }
    echo "</table>";                                         
    echo "</form>";   
}


mysql_free_result($result);

?>


</body>
</html>
