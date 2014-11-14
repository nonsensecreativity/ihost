<?php
mysql_connect("localhost","buyer","wlbuyer")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());


echo "<style type=\"text/css\">

table {border-collapse:collapse;border-spacing:5;}

table td{margin:2;padding:3;font-weight:normal;border:0px solid #000;font-size:12px;}

</style>";


// sql injection inspection
if (!empty($_GET['id'])){
    $_GET['id'] = str_replace(" ","",$_GET['id']);
    $_GET['id'] = str_replace("%20","",$_GET['id']);
    $_GET['id'] = str_replace("\t","",$_GET['id']);
    if (strlen($_GET['id']) > 10){ $_GET['id'] = substr($_GET['id'],0,10); }
    }


echo "<table border='0'>
<tr>
<th></th>
</tr>";

echo "<tr>";
//echo "<td><font size=\"2\"> Total On Shelf : </font></td>";
//echo "<td><font size=\"2\">" . $row->cnt . "</font></td>";
echo "<td></td><td></td>";
//echo "<td> <font size=\"2\"> <a  href=viewsta.php> Refresh  </a></font></td>";
echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a  href=viewitem.php?limit=50> Back to Menu  </a></font></td>";
echo "<td></td><td></td>";
//echo "<td> <font size=\"2\"> <a href=viewswp.php?threshold=-30&pktcount=1&recnum=1&interval=30>View swiping</a></font></td>";
echo "<td></td><td></td>";
//echo "<td> <font size=\"2\"> <a  href=index.html> Back to Login Page  </a></font></td>";
echo "</tr>";
echo "</table>";

$sql = "select * from wlmenu where id ='" . $_GET['id'] . "'";

$result = mysql_query($sql);


echo "<table border='0'>
<tr>
<th><font size=\"2\"></font></th>
</tr>";

while ($row = mysql_fetch_object($result)) {
    echo "<tr>";
    echo "<td><img src = \"" . $row->imgsrc . "\" border=0 width=150 height=150></img></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td> Quan:" . $row->qinserv . $row->qunit . " Unit Price: " . $row->pinserv . $row->punit . "</td>";
    echo "</tr>";
    }

echo "</table>";



echo "<table border='0'>
<tr>
<th></th>
</tr>";

echo "<tr>";

echo "<td>";
echo "<form action=\"makeorder.php\" method=\"GET\">  
    <input type=\"hidden\" name=\"id\" size=\"10\" value=\"" . $_GET['id'] . "\"/> 
    <label>Number to buy: </label>
    <input type=\"text\" name=\"qorder\" size=\"4\" value=\"1\"/> 
    <input type=\"submit\" value=\"OK\"/>  
</form> ";
echo "</td>";

echo "</tr>";
echo "</table>";


//echo "<table border='0'>
//<tr>
//<th><font size=\"2\"></font></th>
//</tr>";

//echo "<tr>";
//echo "<td> sql statement:" . $sql;
//echo "</tr>";

//echo "</table>";


mysql_free_result($result);

?>
