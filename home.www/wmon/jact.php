<?php
mysql_connect("localhost","viewer","wlviewer")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());

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

$sql = "  select id, event, mac, firstseen, lastseen, rectime from viewaction   ";

// adapted to query parameters

if ((!empty($_GET['mac'])) or (!empty($_GET['stime'])) or (!empty($_GET['etime']))) 
    {$sql .= "where  ";}

if (!empty($_GET['mac'])){$sql = $sql . "mac='" . $_GET['mac'] . "'   and ";}

if (!empty($_GET['stime'])){$sql = $sql . "timestampdiff(second,rectime,'" . $_GET['stime'] . "') <= 0   and ";}

if (!empty($_GET['etime'])){$sql = $sql . "timestampdiff(second,rectime,'" . $_GET['etime'] . "') >= 0   and ";}

if ((!empty($_GET['mac'])) or (!empty($_GET['stime'])) or (!empty($_GET['etime']))) 
    {$sql = substr($sql,0,strlen($sql)-5);}

$sql = $sql . "order by rectime desc ";

if ((empty($_GET['mac'])) and (empty($_GET['stime'])) and (empty($_GET['etime'])) and (empty($_GET['limit']))) 
    {$_GET['limit'] = "50";}

if (!empty($_GET['limit'])){$sql = $sql . "limit " . $_GET['limit'] ;}




//
//echo($sql);
$result = mysql_query($sql);

if($result){

    $events=array();
    $i=0;

    while ($row = mysql_fetch_object($result)) {
        $events[$i] = $row;
        $i++;
    }

}

echo json_encode(array('evtlist'=>$events));

mysql_free_result($result);

mysql_close();

?>
