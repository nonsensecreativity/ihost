<?php
include "dbconn.php";
$sql = "  select count(id) as cnt from authclient "  . 
   "  where img <> '" . "" . 
   "'  and manstat ='" . "0" .        
   "'  and stat >='" . "0" .        
   "' " ;
//echo $sql;
$result = mysql_query($sql);
$recrow =  mysql_num_rows($result);

if (!$result or $recrow==0) { // Error handling
    echo "0"; 
}
else{
    $row = mysql_fetch_object($result);
    echo $row->cnt;  
}

mysql_free_result($result);

?>
