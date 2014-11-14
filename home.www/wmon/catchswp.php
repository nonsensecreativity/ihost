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
echo "<td> <font size=\"2\"> <a  href=viewsta.php> View Stations  </a></font></td>";
echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a  href=index.html> Back to Login Page  </a></font></td>";
echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a  href=viewitem.php> Back to Menu  </a></font></td>";
echo "</tr>";

echo "</table>";



echo "<table border='0'>
<tr>
<th></th>
</tr>";

echo "<tr>";

echo "<td>";
echo "<form action=\"viewswp.php\" method=\"GET\">  
    <label>threshold: </label>
    <input type=\"text\" name=\"threshold\" size=\"4\" value=\"-60\"/>  
    <label>pktcount: </label>
    <input type=\"text\" name=\"pktcount\" size=\"4\" value=\"1\"/> 
    <label>recnum: </label>
    <input type=\"text\" name=\"recnum\" size=\"4\" value=\"1\"/> 
    <label>interval: </label>
    <input type=\"text\" name=\"interval\" size=\"4\" value=\"10\"/> 
    <input type=\"submit\" value=\"Start\"/>  
</form> ";
echo "</td>";

echo "</tr>";
echo "</table>";


// sql injection inspection
if (!empty($_GET['mac'])){
    $_GET['mac'] = str_replace(" ","",$_GET['mac']);
    $_GET['mac'] = str_replace("%20","",$_GET['mac']);
    $_GET['mac'] = str_replace("\t","",$_GET['mac']);
    if (strlen($_GET['mac']) > 17){ $_GET['mac'] = substr($_GET['mac'],0,17); }
    }

// adapted to query parameters


$sql = "  select * from viewstation where mac = '" . $_GET['mac'] . "'";


$result = mysql_query($sql);


echo "<table border='0' font-size='36px'>
<tr>
<th><font size=\"2\"></font></th>
</tr>";


while ($row = mysql_fetch_object($result)) {
    echo "<tr>";
    echo "<td><font size=\"32\">" . $row->mac . "</font></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td> by time: " . $row->lastseen . "   rssi: " . $row->rssi . "</td>";
    echo "</tr>";
}

echo "</table>";

$sql = "  select * from wlorder where mac = '" . $_GET['mac'] . "' order by rectime desc limit 1";

//echo "<table border='0'>
//<tr>
//<th></th>
//</tr>";
//echo "<tr>";
//echo "<td></td><td></td>";
//echo "<td> <font size=\"2\">sql statement" . $sql . "</font></td>";
//echo "</tr>";

//echo "</table>";


$result = mysql_query($sql);

echo "<table border='0'>
<tr>
<th><font size=\"2\"></font></th>
</tr>";

$itemid = false;
while ($row = mysql_fetch_object($result)) {
    $itemid = $row->itemid;
    echo "<tr>";
    echo "<td><font size=\"8\">Item id: " . $row->itemid . "  Quantity: " . $row->qorder . "</font></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td> by time: " . $row->rectime . "</td>";
    echo "</tr>";
}

echo "</table>";


$urllink = "http://$_SERVER[HTTP_HOST]";


//strange hack for header function.?f=1 work, &f=1 not work
$redlink = $urllink . "/viewswp.php?threshold=-60&pktcount=1&recnum=1&interval=10";


if (strlen($itemid) == 0)
  {
//   header("Location: " . $redlink);
//   echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"30; URL=" . $redlink  . "\">";
//   alertInfor("no order found",$redlink);

//   echo "<script>window.location =\"" . $redlink . "\";</script>";
   echo "<script>alert(\"No Order Found\");window.location =\"" . $redlink . "\";</script>";
   die();
  }


$sql = "  select * from wlmenu where id = '" . $itemid . "'";



$result = mysql_query($sql);


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
