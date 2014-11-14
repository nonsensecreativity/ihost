<?php
mysql_connect("localhost","viewer","wlviewer")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());

$result = mysql_query("select count(mac) as cnt from wlsta");

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
echo "<td width= 30%>MAC:</td>
      <td width= 10%>RecNum:</td>
      <td width= 35%>From:</td>
      <td width= 25%>To:</td>";
echo "</tr>";

echo "</table>";


echo "<table border='0' widht=\"100%\">
<tr>
<th></th>
</tr>";

echo "<tr>";

echo "<td>";
echo "<form action=\"viewact.php\" method=\"GET\">  
    <input type=\"text\" name=\"mac\" size=\"18\" value=\"" . $_GET['mac'] . "\"/>  
    <input type=\"text\" name=\"limit\" size=\"4\" value=\"" . $_GET['limit'] . "\"/> 
    <input type=\"text\" name=\"stime\" size=\"20\" value=\"" . $_GET['stime'] . "\"/> 
    <input type=\"text\" name=\"etime\" size=\"20\" value=\"" . $_GET['etime'] . "\"/> 
    <input type=\"submit\" value=\"Query\"/>  
</form> ";
echo "</td>";

echo "</tr>";
echo "</table>";




$sql = "  select * from viewaction   ";

// sql injection inspection
if (!empty($_GET['mac'])){
    $_GET['mac'] = str_replace(" ","",$_GET['mac']);
    $_GET['mac'] = str_replace("%20","",$_GET['mac']);
    $_GET['mac'] = str_replace("\t","",$_GET['mac']);
    if (strlen($_GET['mac']) > 17){ $_GET['mac'] = substr($_GET['mac'],0,17); }
    }
if (!empty($_GET['limit'])){
    $_GET['limit'] = str_replace(" ","",$_GET['limit']);
    $_GET['limit'] = str_replace("%20","",$_GET['limit']);
    $_GET['limit'] = str_replace("\t","",$_GET['limit']);
    if (strlen($_GET['limit']) > 4){ $_GET['limit'] = substr($_GET['limit'],0,4); }
    }
//echo $_GET['limit'];
if (!empty($_GET['stime'])){
    $dtstr = str_split($_GET['stime'],11);
    $dtstr[0] = str_replace(" ","",$dtstr[0]);
    $dtstr[0] = str_replace("%20","",$dtstr[0]);
    $dtstr[0] = str_replace("\t","",$dtstr[0]);
    $dtstr[1] = str_replace(" ","",$dtstr[1]);
    $dtstr[1] = str_replace("%20","",$dtstr[1]);
    $dtstr[1] = str_replace("\t","",$dtstr[1]);
    $_GET['stime'] = $dtstr[0] . " " . $dtstr[1];
    if (strlen($_GET['stime']) > 19){$_GET['stime'] = substr($_GET['stime'],0,19); }
    }

if (!empty($_GET['etime'])){
    $dtstr = str_split($_GET['etime'],11);
    $dtstr[0] = str_replace(" ","",$dtstr[0]);
    $dtstr[0] = str_replace("%20","",$dtstr[0]);
    $dtstr[0] = str_replace("\t","",$dtstr[0]);
    $dtstr[1] = str_replace(" ","",$dtstr[1]);
    $dtstr[1] = str_replace("%20","",$dtstr[1]);
    $dtstr[1] = str_replace("\t","",$dtstr[1]);
    $_GET['etime'] = $dtstr[0] ." " . $dtstr[1];
    if (strlen($_GET['etime']) > 19){ $_GET['etime'] = substr($_GET['etime'],0,19); }
    }
//


// adapted to query parameters

if ((!empty($_GET['mac'])) or (!empty($_GET['stime'])) or (!empty($_GET['etime']))) 
    {$sql .= "where  ";}

if (!empty($_GET['mac'])){$sql = $sql . "mac='" . $_GET['mac'] . "'   and ";}

if (!empty($_GET['stime'])){$sql = $sql . "timestampdiff(second,rectime,'" . $_GET['stime'] . "') <= 0   and ";}

if (!empty($_GET['etime'])){$sql = $sql . "timestampdiff(second,rectime,'" . $_GET['etime'] . "') >= 0   and ";}

if ((!empty($_GET['mac'])) or (!empty($_GET['stime'])) or (!empty($_GET['etime']))) 
    {$sql = substr($sql,0,strlen($sql)-5);}

$sql = $sql . "order by rectime desc ";

if (!empty($_GET['limit'])){$sql = $sql . "limit " . $_GET['limit'] ;}


//echo "<table border='0'>
//<tr>
//<th></th>
//</tr>";
//echo "<tr>";
//echo "<td></td><td></td>";
//echo "<td> <font size=\"2\">sql statement:" . $sql . "</font></td>";
//echo "</tr>";

//echo "</table>";


//

$result = mysql_query($sql);

echo "<table border='0' width=\"100%\">
<tr>
<th width = \"5%\" align=\"left\">ID</th>
<th width = \"10%\" align=\"left\">EVENT</th>
<th width = \"20%\" align=\"left\">MAC</th>
<th width = \"20%\" align=\"left\">FirstPkt</th>
<th width = \"20%\" align=\"left\">TrigPkt</th>
<th width = \"25%\" align=\"left\">Rectime</th>
</tr>";


while ($row = mysql_fetch_object($result)) {
    echo "<tr>";
    echo "<td>" . $row->id . "</td>";
    echo "<td>" . $row->event . "</td>";
    echo "<td>" . $row->mac . "</td>";
    echo "<td>" . $row->firstseen . "</td>";
    echo "<td>" . $row->lastseen . "</td>";
    echo "<td>" . $row->rectime . "</td>";
    echo "</tr>";
}

echo "</table>";


mysql_free_result($result);

?>

