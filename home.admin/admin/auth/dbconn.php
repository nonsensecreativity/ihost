<?php
$conn = mysql_connect("127.0.0.1","root","rootatussp")
        or die ('Not connected : ' . mysql_error());
mysql_set_charset('utf8', $conn);
mysql_select_db("wlsp") or die ();
?>

