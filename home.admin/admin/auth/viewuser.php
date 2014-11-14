
<?php
include "dbconn.php";


echo "<style type=\"text/css\">
table {border-collapse:collapse;border-spacing:5;}
table td{margin:2;padding:3;font-weight:normal;border:0px solid #000;font-size:12px;}
</style>";

echo "<table border='0'>
<tr>
<th></th>
</tr>";

//$sql = "select id,mac,ip,phone,rectime,sendtime from authsms where optflag='1' order by id desc limit 50";
$sql = "select id,mac,ip,phone,rectime,sendtime from authsms where phone<>''  order by id desc limit 50";

$result = mysql_query($sql);


echo "<table border='0'>
<tr>
<th width=\"5%\" align=\"left\"><font size=\"2\">ID</font></th>
<th width=\"15%\" align=\"left\"><font size=\"2\">MAC</font></th>
<th width=\"13%\" align=\"left\"><font size=\"2\">IP</font></th>
<th width=\"12%\" align=\"left\"><font size=\"2\">PHONE</font></th>
<th width=\"20%\" align=\"left\"><font size=\"2\">REQ TIME</font></th>
<th width=\"20%\" align=\"left\"><font size=\"2\">SEND TIME</font></th>
</tr>";

while ($row = mysql_fetch_object($result)) {
    echo "<tr>";
    echo "<td>" . $row->id . "</td>";
    echo "<td>" . $row->mac . "</td>";
    echo "<td>" . $row->ip . "</td>";
    echo "<td>" . $row->phone . "</td>";
    echo "<td>" . $row->rectime . "</td>";
    echo "<td>" . $row->sendtime . "</td>";
    echo "</tr>";
}

echo "</table>";


mysql_free_result($result);

?>
