<?php
mysql_connect("localhost","viewer","wlviewer")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());

echo "<head> <meta http-equiv=refresh content=\"2\"> </head>";

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


$sql = "  select mac, lastseen, rssi from viewstation where rssi >= '" . $threshold . "'
         and npacket >= '" . $pktcount . "'
         and timestampdiff(second,lastseen,now()) <= " .$interval . "
         order by lastseen desc  limit " . $recnum  ;
//echo($sql);
//echo("<br>");

$result = mysql_query($sql);


if($result){

    $swaps=array();
    $i=0;

    while ($row = mysql_fetch_object($result)) {
        $swaps[$i] = $row;
        $i++;
    }

}


echo json_encode(array('swplist'=>$swaps));



// check confirmation status

$sql = "  select mac, cfirmtime from wlorder where  timestampdiff(second,cfirmtime,now()) <= " .$interval . "
         order by cfirmtime desc  limit " . $recnum  ;

//echo($sql);
//echo("<br>");

$result = mysql_query($sql);

if($result){

    $cfirms=array();
    $i=0;

    while ($row = mysql_fetch_object($result)) {
        $cfirms[$i] = $row;
        $i++;
    }

}


echo json_encode(array('cfirmlist'=>$cfirms));

mysql_free_result($result);

mysql_close();


?>
