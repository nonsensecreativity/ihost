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
if (!empty($_GET['qorder'])){
    $_GET['qorder'] = str_replace(" ","",$_GET['qorder']);
    $_GET['qorder'] = str_replace("%20","",$_GET['qorder']);
    $_GET['qorder'] = str_replace("\t","",$_GET['qorder']);
    if (strlen($_GET['qorder']) > 5){ $_GET['id'] = substr($_GET['qorder'],0,5); }
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

echo "<table border='0'>
<tr>
<th></th>
</tr>";

echo "<tr>";
//echo "<td><font size=\"2\"> Total On Shelf : </font></td>";
//echo "<td><font size=\"2\">" . $row->cnt . "</font></td>";
//echo "<td></td><td></td>";
//echo "<td> <font size=\"2\"> <a  href=viewsta.php> Refresh  </a></font></td>";
//echo "<td></td><td></td>";
echo "<td> <font size=\"2\"> <a  href=viewitem.php> Back to Menu  </a></font></td>";
echo "<td></td><td></td>";
//echo "<td> <font size=\"2\"> <a href=viewswp.php?threshold=-30&pktcount=1&recnum=1&interval=30>View swiping</a></font></td>";
echo "<td></td><td></td>";
//echo "<td> <font size=\"2\"> <a  href=index.html> Back to Login Page  </a></font></td>";
echo "</tr>";
echo "</table>";

$sql = "insert into wlorder set itemid ='" . $_GET['id'] . 
       "', qorder ='" . $_GET['qorder'] . 
       "', ip = '" . $ipAddress .
       "', xip = '" . $_SERVER['HTTP_X_FORWARDED_FOR'] .
       "', mac = '" . $macAddr .
       "', mactype = '" . $macType .
       "', rectime = now()" ;

$result = mysql_query($sql);

if (!$result)
  {
  die('Error: ' . mysql_error());
  }
echo "Success";




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
