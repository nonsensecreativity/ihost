<?php
mysql_connect("localhost","buyer","wlbuyer")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());



echo "<style type=\"text/css\">

table {border-collapse:collapse;border-spacing:5;}

table td{margin:2;padding:3;font-weight:normal;border:0px solid #000;font-size:12px;}

</style>";

echo "<table border='0'>
<tr>
<th></th>
</tr>";

echo "<tr>";
echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a  href=viewmyorder.php> my order  </a></font></td>";
echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a href=viewswp.php?threshold=-55&pktcount=1&recnum=1&interval=15>View swiping</a></font></td>";
echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a  href=index.html> Back to Login Page  </a></font></td>";
echo "</tr>";
echo "</table>";


$result = mysql_query("select * from wlmenu order by rectime desc");


echo "<table border='0'>
<tr>
<th><font size=\"2\"></font></th>
</tr>";


while ($row = mysql_fetch_object($result)) {
    echo "<tr>";
    echo "<td><a href=wlorder.php?id=" . $row->id . "><img src = \"" . $row->imgsrc . "\" border=0 width=150 height=150></img></a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td> Quan:" . $row->qinserv . $row->qunit . " Unit Price: " . $row->pinserv . $row->punit . "</td>";
    echo "</tr>";
}

echo "</table>";


mysql_free_result($result);

?>
