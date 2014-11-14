<?php
mysql_connect("localhost","viewer","wlviewer")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());

$sql = "select id, mac, firstseen, lastseen, ssid, rssi, stat, npacket from viewstation order by lastseen desc";

//echo($sql);
$result = mysql_query($sql);

if($result){

    $stations=array();
    $i=0;

    while ($row = mysql_fetch_object($result)) {
        $stations[$i] = $row;
        $i++;
    }

}

echo json_encode(array('stalist'=>$stations));

mysql_free_result($result);

mysql_close();


?>
