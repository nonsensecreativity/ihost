<?php
mysql_connect("localhost","viewer","wlviewer")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());

$result = mysql_query("select count(mac) as cnt from viewstation");

$row = mysql_fetch_object($result);


echo "<style type=\"text/css\">

table {border-collapse:collapse;border-spacing:5;}

table td{margin:2;padding:3;font-weight:normal;border:0px solid #000;font-size:12px;}

</style>";

echo "<table border='0'>
<tr>
<th></th>
</tr>";

echo "<tr>";
echo "<td><font size=\"2\"> TotalAlived : </font></td>";
echo "<td><font size=\"2\">" . $row->cnt . "</font></td>";
echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a  href=viewsta.php> Refresh  </a></font></td>";
echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a  href=viewact.php?limit=50> View Actions  </a></font></td>";
echo "<td></td><td></td>";
//echo "<td> <font size=\"2\"> <a href=viewswp.php?threshold=-60&pktcount=1&recnum=1&interval=10>View swiping</a></font></td>";
echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a  href=index.html> Back to index  </a></font></td>";
echo "</tr>";
echo "</table>";


$result = mysql_query("select * from viewstation order by lastseen desc");





echo "<table border='0'>
<tr>
<th><font size=\"2\">ID</font></th>
<th><font size=\"2\">MAC</font></th>
<th><font size=\"2\">Firstseen</font></th>
<th><font size=\"2\">Lastseen</font></th>
<th><font size=\"2\">SSID</font></th>
<th><font size=\"2\">RSSI</font></th>
<th><font size=\"2\">STAT</font></th>
<th><font size=\"2\">Pktount</font></th>
</tr>";


while ($row = mysql_fetch_object($result)) {
    echo "<tr>";
    echo "<td>" . $row->id . "</td>";
    echo "<td><a href=viewact.php?mac=" . $row->mac . "&limit=30 target=\"_new\">" . $row->mac . "</a></td>";
    echo "<td>" . $row->firstseen . "</td>";
    echo "<td>" . $row->lastseen . "</td>";
    echo "<td align=\"center\">" . $row->ssid . "</td>";
    echo "<td>" . $row->rssi . "</td>";
    echo "<td>" . $row->stat . "</td>";
    echo "<td>" . $row->npacket . "</td>";
    echo "</tr>";
}

echo "</table>";


mysql_free_result($result);

?>
