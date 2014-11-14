<?php
mysql_connect("localhost","viewer","wlviewer")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());


echo "<head> <meta http-equiv=refresh content=\"2\"> </head>";

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



echo "<table border='0'>
<tr>
<th></th>
</tr>";

echo "<tr>";

echo "<td>";
echo "<form action=\"viewswp.php\" method=\"GET\">  
    <label>threshold: </label>
    <input type=\"text\" name=\"threshold\" size=\"4\" value=\"" . $_GET['threshold'] . "\"/>  
    <label>pktcount: </label>
    <input type=\"text\" name=\"pktcount\" size=\"4\" value=\"" . $_GET['pktcount'] . "\"/> 
    <label>recnum: </label>
    <input type=\"text\" name=\"recnum\" size=\"4\" value=\"" . $_GET['recnum'] . "\"/> 
    <label>interval: </label>
    <input type=\"text\" name=\"interval\" size=\"4\" value=\"" . $_GET['interval'] . "\"/> 
    <input type=\"submit\" value=\"Start\"/>  
</form> ";
echo "</td>";

echo "</tr>";
echo "</table>";


// sql injection inspection
if (!empty($_GET['threshold'])){
    $_GET['threshold'] = str_replace(" ","",$_GET['threshold']);
    $_GET['threshold'] = str_replace("%20","",$_GET['threshold']);
    $_GET['threshold'] = str_replace("\t","",$_GET['threshold']);
    if (strlen($_GET['threshold']) > 4){ $_GET['threshold'] = substr($_GET['threshold'],0,4); }
    }

if (!empty($_GET['pktcount'])){
    $_GET['pktcount'] = str_replace(" ","",$_GET['pktcount']);
    $_GET['pktcount'] = str_replace("%20","",$_GET['pktcount']);
    $_GET['pktcount'] = str_replace("\t","",$_GET['pktcount']);
    if (strlen($_GET['pktcount']) > 1){ $_GET['pktcount'] = substr($_GET['pktcount'],0,1); }
    }

if (!empty($_GET['recnum'])){
    $_GET['recnum'] = str_replace(" ","",$_GET['recnum']);
    $_GET['recnum'] = str_replace("%20","",$_GET['recnum']);
    $_GET['recnum'] = str_replace("\t","",$_GET['recnum']);
    if (strlen($_GET['recnum']) > 1){ $_GET['recnum'] = substr($_GET['recnum'],0,1); }
    }

if (!empty($_GET['interval'])){
    $_GET['interval'] = str_replace(" ","",$_GET['interval']);
    $_GET['interval'] = str_replace("%20","",$_GET['interval']);
    $_GET['interval'] = str_replace("\t","",$_GET['interval']);
    if (strlen($_GET['interval']) > 3){ $_GET['interval'] = substr($_GET['interval'],0,3); }
    }

// adapted to query parameters

$threshold = -60;
$pktcount = 1;
$recnum = 1;
$interval = 10;


if (!empty($_GET['threshold'])){$threshold = $_GET['threshold'];}

if (!empty($_GET['pktcount'])){$pktcount = $_GET['pktcount'] ;}

if (!empty($_GET['recnum'])){$recnum = $_GET['recnum'];}

if (!empty($_GET['interval'])){$interval = $_GET['interval'];}


$sql = "  select * from viewstation where rssi >= '" . $threshold . "'
         and npacket >= '" . $pktcount . "'
         and timestampdiff(second,lastseen,now()) <= " .$interval . "
         order by lastseen desc  limit " . $recnum  ;


//echo "<table border='0'>
//<tr>
//<th></th>
//</tr>";
//echo "<tr>";
//echo "<td></td><td></td>";
//echo "<td> <font size=\"2\">sql statement" . $sql . "</font></td>";
//echo "</tr>";

//echo "</table>";


//

$result = mysql_query($sql);


echo "<table border='0' font-size='36px'>
<tr>
<th><font size=\"2\"></font></th>
</tr>";

$swpmac=false;

while ($row = mysql_fetch_object($result)) {
    $swpmac = $row->mac;
    echo "<tr>";
    echo "<td><font size=\"32\">" . $row->mac . "</font></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td> by time: " . $row->lastseen . "   rssi: " . $row->rssi . "</td>";
    echo "</tr>";
}

echo "</table>";


// check confirmation status

$sql = "  select * from wlorder where  timestampdiff(second,cfirmtime,now()) <= " .$interval . "
         order by cfirmtime desc  limit " . $recnum  ;

$result = mysql_query($sql);

// check sql statement
//echo "<table border='0'>
//<tr>
//<th></th>
//</tr>";
//echo "<tr>";
//echo "<td></td><td></td>";
//echo "<td> <font size=\"2\">sql statement" . $sql . "</font></td>";
//echo "</tr>";
//echo "</table>";


echo "<table border='0' font-size='36px'>
<tr>
<th><font size=\"2\"></font></th>
</tr>";

$cfirmmac=false;

while ($row = mysql_fetch_object($result)) {
    $cfirmmac = $row->mac;
    echo "<tr>";
    echo "<td><font size=\"32\">" . $row->mac . "</font></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td> by time: " . $row->cfirmtime . "</td>";
    echo "</tr>";
}

echo "</table>";

if (strlen($swpmac) == 0)
  {
   $swpmac = $cfirmmac;
  }


mysql_free_result($result);


//$urllink = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$urllink = "http://$_SERVER[HTTP_HOST]";

$redlink = $urllink . "/catchswp.php?mac=" . $swpmac;

//echo "<table border='0'>
//<tr>
//<th></th>
//</tr>";
//echo "<tr>";
//echo "<td></td><td></td>";
//echo "<td> <font size=\"2\">redirect link" . $redlink . "</font></td>";
//echo "</tr>";
//echo "</table>";

if (strlen($swpmac) != 0)
  {
//   echo "<script>window.location =\"" . $redlink . "\";</script>";
   header("Location: " . $redlink);
   die();
  }


?>
