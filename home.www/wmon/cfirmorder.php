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
echo "</tr>";

echo "</table>";

// sql injection inspection
if (!empty($_GET['orderid'])){
    $_GET['orderid'] = str_replace(" ","",$_GET['orderid']);
    $_GET['orderid'] = str_replace("%20","",$_GET['orderid']);
    $_GET['orderid'] = str_replace("\t","",$_GET['orderid']);
    if (strlen($_GET['orderid']) > 6){ $_GET['mac'] = substr($_GET['orderid'],0,6); }
    }


// get client ip address and mac address
$ipAddress=$_SERVER['REMOTE_ADDR'];
$macAddr=false;
$macType=false;

#run the external command, break output into lines
$arp=`arp -n $ipAddress`;
$lines=explode("\n", $arp);

#look for the output line describing our IP address
foreach($lines as $line)
{
   $cols=preg_split('/\s+/', trim($line));
   if ($cols[0]==$ipAddress)
   {
       $macAddr=$cols[2];
       $macType=$cols[1];
   }
}

// adapted to query parameters


$sql = "  select * from wlorder where id = '" . $_GET['orderid'] . "'";

//echo "<table border='0'>
//<tr>
//<th></th>
//</tr>";
//echo "<tr>";
//echo "<td></td><td></td>";
//echo "<td> <font size=\"2\">sql statement" . $sql . "</font></td>";
//echo "</tr>";

echo "</table>";


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


$sql = "  select * from wlmenu where id = '" . $itemid . "'";

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


while ($row = mysql_fetch_object($result)) {
    echo "<tr>";
    echo "<td><a href=wlorder.php?id=" . $row->id . "><img src = \"" . $row->imgsrc . "\" border=0 width=150 height=150></img></a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td> Quan:" . $row->qinserv . $row->qunit . " Unit Price: " . $row->pinserv . $row->punit . "</td>";
    echo "</tr>";
}

echo "</table>";


$sql = "  update wlorder set cfirm='100', cfirmtime=now() where id = '" . $_GET['orderid'] . "'";
$result = mysql_query($sql);

$urllink = "http://$_SERVER[HTTP_HOST]";
$redlink = $urllink . "/viewmyorder.php";


if (!$result)
  {
   header("Location: " . $redlink);
   die('Confirm Order Error ');
  }

echo "Order Confirmed on site";


mysql_free_result($result);

?>
