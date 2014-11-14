<?php
mysql_connect("127.0.0.1","actrec","actrecatussp")
        or die ();

mysql_select_db("wlsp") or die ();

echo "<style type=\"text/css\">
table {border-collapse:collapse;border-spacing:5;}
table td{margin:2;padding:3;font-weight:normal;border:0px solid #000;font-size:12px;}
</style>";

echo "<table border='0'>
<tr>
<th></th>
</tr>";

$result = mysql_query("select * from actvst order by id desc limit 50");


echo "<table border='0'>
<tr>
<th width=\"5%\" align=\"left\"><font size=\"2\">ID</font></th>
<th width=\"15%\" align=\"left\"><font size=\"2\">Time</font></th>
<th width=\"13%\" align=\"left\"><font size=\"2\">Src MAC</font></th>
<th width=\"12%\" align=\"left\"><font size=\"2\">Src IP</font></th>
<th width=\"12%\" align=\"left\"><font size=\"2\">Dst IP</font></th>
<th width=\"38%\" align=\"left\"><font size=\"2\">URL</font></th>
</tr>";

while ($row = mysql_fetch_object($result)) {
    echo "<tr>";
    echo "<td>" . $row->id . "</td>";
    echo "<td>" . $row->pkttime . "</td>";
    echo "<td>" . $row->srcmac . "</td>";
    echo "<td><a href=\"pushget.php?ip=" .  $row->srcip . "\">" . $row->srcip . "</a></td>";
    echo "<td>" . $row->destip . "</td>";
    echo "<td>" . substr($row->url,0,50) . "</td>";
    echo "</tr>";
}

echo "</table>";


mysql_free_result($result);

?>

