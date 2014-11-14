<?php
mysql_connect("127.0.0.1","proxy","proxyatussp")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());


echo "<style type=\"text/css\">

table {border-collapse:collapse;border-spacing:5;}

table td{margin:2;padding:3;font-weight:normal;border:0px solid #000;font-size:12px;}

</style>";


// sql injection inspection
if (!empty($_GET['ip'])){
    $_GET['ip'] = str_replace(" ","",$_GET['ip']);
    $_GET['ip'] = str_replace("%20","",$_GET['ip']);
    $_GET['ip'] = str_replace("\t","",$_GET['ip']);
    if (strlen($_GET['ip']) > 16){ $_GET['ip'] = substr($_GET['ip'],0,16); }
    }
//

$sql = " select dura,prio,rurl,rurltoken from pushrurl where srcip =  '" . $_GET['ip']  . "' order by ftime desc limit 1";

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

$row = mysql_fetch_object($result);

echo "<form action=\"pushset.php\" method=\"POST\">
    <input type=\"hidden\" name=\"ip\" size=\"18\"  value=\"" . $_GET['ip'] . "\"/>
    <br /><label>From time: </label><br />    
    <input type=\"text\" name=\"ftime\" size=\"20\" value=\"" . date('Y-m-d H:i:s') . "\"/> 
    <br /><label>Duration: </label><br />  
    <input type=\"text\" name=\"dura\" size=\"4\" value=\"" . $row->dura . "\"/> 
    <br /><label>Priority: </label><br />  
    <input type=\"text\" name=\"prio\" size=\"4\" value=\"" . $row->prio . "\"/> 
    <br /><label>Redirct Url: </label><br />  
    <input type=\"text\" name=\"url\" size=\"70\" value=\"" . $row->rurl . "\"/>
    <br /><label>Url token: </label><br />  
    <input type=\"text\" name=\"urltoken\" size=\"30\" value=\"" . $row->rurltoken . "\"/>
    <br />
    <input type=\"submit\" value=\"Submit\"/>  
</form> ";


mysql_free_result($result);

?>


