<?php
mysql_connect("127.0.0.1","proxy","proxyatussp")
        or die ('Not connected : ' . mysql_error());

mysql_select_db("wlsp") or die ('Can\'t use foo : ' . mysql_error());


echo "<style type=\"text/css\">

table {border-collapse:collapse;border-spacing:5;}

table td{margin:2;padding:3;font-weight:normal;border:0px solid #000;font-size:12px;}

</style>";


// sql injection inspection
if (!empty($_POST['ip'])){
    $_POST['ip'] = str_replace(" ","",$_POST['ip']);
    $_POST['ip'] = str_replace("%20","",$_POST['ip']);
    $_POST['ip'] = str_replace("\t","",$_POST['ip']);
    if (strlen($_POST['ip']) > 16){ $_POST['ip'] = substr($_POST['ip'],0,16); }
    }
if (!empty($_POST['ftime'])){
    $_POST['ftime'] = str_replace("\t","",$_POST['ftime']);
    if (strlen($_POST['ftime']) > 20){ $_POST['ftime'] = substr($_POST['ftime'],0,20); }
    }
if (!empty($_POST['dura'])){
    $_POST['dura'] = str_replace(" ","",$_POST['dura']);
    $_POST['dura'] = str_replace("%20","",$_POST['dura']);
    $_POST['dura'] = str_replace("\t","",$_POST['dura']);
    if (strlen($_POST['dura']) > 4){ $_POST['dura'] = substr($_POST['dura'],0,4); }
    }
if (!empty($_POST['prio'])){
    $_POST['prio'] = str_replace(" ","",$_POST['prio']);
    $_POST['prio'] = str_replace("%20","",$_POST['prio']);
    $_POST['prio'] = str_replace("\t","",$_POST['prio']);
    if (strlen($_POST['prio']) > 4){ $_POST['prio'] = substr($_POST['prio'],0,4); }
    }
if (!empty($_POST['url'])){
    $_POST['url'] = str_replace(" ","",$_POST['url']);
    $_POST['url'] = str_replace("%20","",$_POST['url']);
    $_POST['url'] = str_replace("\t","",$_POST['url']);
    if (strlen($_POST['url']) > 70){ $_POST['url'] = substr($_POST['url'],0,70); }
    }
if (!empty($_POST['urltoken'])){
    $_POST['urltoken'] = str_replace(" ","",$_POST['urltoken']);
    $_POST['urltoken'] = str_replace("%20","",$_POST['urltoken']);
    $_POST['urltoken'] = str_replace("\t","",$_POST['urltoken']);
    if (strlen($_POST['urltoken']) > 30){ $_POST['urltoken'] = substr($_POST['urltoken'],0,30); }
    }

//

$sql = " insert into pushrurl set srcip =  '" . $_POST['ip']  . "', ";
$sql = $sql . "  dura = '" . $_POST['dura']  . "', ";
$sql = $sql . "  prio = '" . $_POST['prio']  . "', ";
$sql = $sql . "  rurl = '" . $_POST['url']  . "', ";
$sql = $sql . "  rurltoken = '" . $_POST['urltoken']  . "', ";
$sql = $sql . "  ftime = '" . $_POST['ftime']  . "', ";
$sql = $sql . "  type = '" . "10"  . "', ";
$sql = $sql . "  active = '" . "1"  . "', ";
$sql = $sql . "  rectime = " . "now()"  . " ";

//echo $sql;
$result = mysql_query($sql);
if (!$result)
  {
  die('Error: ' . mysql_error());
  }
echo "Success";

mysql_free_result($result);


$proxyip = "172.16.0.1";
$proxyport = "3128";

$str = "sudo iptables -t nat -A PREROUTING -s  " . $_POST['ip'];
$str =  $str . " -p tcp --dport 80  -j DNAT --to  " . $proxyip . ":" . $proxyport;
//echo $str;
$output = shell_exec($str);


?>


