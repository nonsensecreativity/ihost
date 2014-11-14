<?php
if (!empty($_GET['res'])){
    $_GET['res'] = str_replace(" ","",$_GET['res']);
    $_GET['res'] = str_replace("%20","",$_GET['res']);
    $_GET['res'] = str_replace("\t","",$_GET['res']);
    if (strlen($_GET['res']) > 16){ $_GET['res'] = substr($_GET['res'],0,16); }
    }

if (!empty($_GET['uamip'])){
    $_GET['uamip'] = str_replace(" ","",$_GET['uamip']);
    $_GET['uamip'] = str_replace("%20","",$_GET['uamip']);
    $_GET['uamip'] = str_replace("\t","",$_GET['uamip']);
    if (strlen($_GET['uamip']) > 64){ $_GET['uamip'] = substr($_GET['uamip'],0,64); }
    }

if (!empty($_GET['uamport'])){
    $_GET['uamport'] = str_replace(" ","",$_GET['uamport']);
    $_GET['uamport'] = str_replace("%20","",$_GET['uamport']);
    $_GET['uamport'] = str_replace("\t","",$_GET['uamport']);
    if (strlen($_GET['uamport']) > 6){ $_GET['uamport'] = substr($_GET['uamport'],0,6); }
    }

if (!empty($_GET['sessionid'])){
    $_GET['sessionid'] = str_replace(" ","",$_GET['sessionid']);
    $_GET['sessionid'] = str_replace("%20","",$_GET['sessionid']);
    $_GET['sessionid'] = str_replace("\t","",$_GET['sessionid']);
    if (strlen($_GET['sessionid']) > 16){ $_GET['sessionid'] = substr($_GET['sessionid'],0,16); }
    }

if (!empty($_GET['challenge'])){
    $_GET['challenge'] = str_replace(" ","",$_GET['challenge']);
    $_GET['challenge'] = str_replace("%20","",$_GET['challenge']);
    $_GET['challenge'] = str_replace("\t","",$_GET['challenge']);
    if (strlen($_GET['challenge']) > 64){ $_GET['challenge'] = substr($_GET['challenge'],0,64); }
    }

if (!empty($_GET['mac'])){
    $_GET['mac'] = str_replace(" ","",$_GET['mac']);
    $_GET['mac'] = str_replace("%20","",$_GET['mac']);
    $_GET['mac'] = str_replace("\t","",$_GET['mac']);
    if (strlen($_GET['mac']) > 17){ $_GET['mac'] = substr($_GET['mac'],0,17); }
    }

if (!empty($_GET['ip'])){
    $_GET['ip'] = str_replace(" ","",$_GET['ip']);
    $_GET['ip'] = str_replace("%20","",$_GET['ip']);
    $_GET['ip'] = str_replace("\t","",$_GET['ip']);
    if (strlen($_GET['ip']) > 64){ $_GET['ip'] = substr($_GET['ip'],0,64); }
    }

if (!empty($_GET['md'])){
    $_GET['md'] = str_replace(" ","",$_GET['md']);
    $_GET['md'] = str_replace("\t","",$_GET['md']);
    if (strlen($_GET['md']) > 64){ $_GET['md'] = substr($_GET['md'],0,64); }
    }

if (!empty($_GET['called'])){
    $_GET['called'] = str_replace(" ","",$_GET['called']);
    $_GET['called'] = str_replace("%20","",$_GET['called']);
    $_GET['called'] = str_replace("\t","",$_GET['called']);
    if (strlen($_GET['called']) > 17){ $_GET['called'] = substr($_GET['called'],0,17); }
    }

if (!empty($_GET['nasid'])){
    $_GET['nasid'] = str_replace(" ","",$_GET['nasid']);
    $_GET['nasid'] = str_replace("\t","",$_GET['nasid']);
    if (strlen($_GET['nasid']) > 6){ $_GET['nasid'] = substr($_GET['nasid'],0,6); }
    }

if (!empty($_GET['userurl'])){
    $_GET['userurl'] = str_replace(" ","",$_GET['userurl']);
    $_GET['userurl'] = str_replace("\t","",$_GET['userurl']);
    if (strlen($_GET['userurl']) > 128){ $_GET['userurl'] = substr($_GET['userurl'],0,128); }
    }

?>
