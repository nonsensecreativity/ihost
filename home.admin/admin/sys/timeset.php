<html>
<title>stime</title>
<body>
<?php
//  inspection
if (!empty($_GET['timestr'])){
    $_GET['timestr'] = str_replace(" ","",$_GET['timestr']);
    $_GET['timestr'] = str_replace("%20","",$_GET['timestr']);
    $_GET['timestr'] = str_replace("\t","",$_GET['timestr']);
    if (strlen($_GET['timestr']) > 20){ $_GET['timestr'] = substr($_GET['timestr'],0,20); }
    }
//$strtime = gmdate("Y-m-d\TH:i:s\Z", 1333699439);
//$strtime = date("Y-m-d\TH:i:s\Z",1333699439);
$str = "sudo date +%s -s @'" . $_GET['timestr'] . "'"; // 'Fri Mar 21 15:39:30 CST 2014' ";
//echo $str;
$output = shell_exec($str);
$output = shell_exec("sudo date");
echo "<pre>$output</pre>";
?> 
</body>

