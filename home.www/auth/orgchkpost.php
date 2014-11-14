<?php

if (!empty($_POST['res'])){
    $_POST['res'] = str_replace(" ","",$_POST['res']);
    $_POST['res'] = str_replace("%20","",$_POST['res']);
    $_POST['res'] = str_replace("\t","",$_POST['res']);
    if (strlen($_POST['res']) > 16){ $_POST['res'] = substr($_POST['res'],0,16); }
    }

if (!empty($_POST['uamip'])){
    $_POST['uamip'] = str_replace(" ","",$_POST['uamip']);
    $_POST['uamip'] = str_replace("%20","",$_POST['uamip']);
    $_POST['uamip'] = str_replace("\t","",$_POST['uamip']);
    if (strlen($_POST['uamip']) > 64){ $_POST['uamip'] = substr($_POST['uamip'],0,64); }
    }

if (!empty($_POST['uamport'])){
    $_POST['uamport'] = str_replace(" ","",$_POST['uamport']);
    $_POST['uamport'] = str_replace("%20","",$_POST['uamport']);
    $_POST['uamport'] = str_replace("\t","",$_POST['uamport']);
    if (strlen($_POST['uamport']) > 6){ $_POST['uamport'] = substr($_POST['uamport'],0,6); }
    }

if (!empty($_POST['sessionid'])){
    $_POST['sessionid'] = str_replace(" ","",$_POST['sessionid']);
    $_POST['sessionid'] = str_replace("%20","",$_POST['sessionid']);
    $_POST['sessionid'] = str_replace("\t","",$_POST['sessionid']);
    if (strlen($_POST['sessionid']) > 16){ $_POST['sessionid'] = substr($_POST['sessionid'],0,16); }
    }

if (!empty($_POST['challenge'])){
    $_POST['challenge'] = str_replace(" ","",$_POST['challenge']);
    $_POST['challenge'] = str_replace("%20","",$_POST['challenge']);
    $_POST['challenge'] = str_replace("\t","",$_POST['challenge']);
    if (strlen($_POST['challenge']) > 64){ $_POST['challenge'] = substr($_POST['challenge'],0,64); }
    }

if (!empty($_POST['mac'])){
    $_POST['mac'] = str_replace(" ","",$_POST['mac']);
    $_POST['mac'] = str_replace("%20","",$_POST['mac']);
    $_POST['mac'] = str_replace("\t","",$_POST['mac']);
    if (strlen($_POST['mac']) > 17){ $_POST['mac'] = substr($_POST['mac'],0,17); }
    }

if (!empty($_POST['ip'])){
    $_POST['ip'] = str_replace(" ","",$_POST['ip']);
    $_POST['ip'] = str_replace("%20","",$_POST['ip']);
    $_POST['ip'] = str_replace("\t","",$_POST['ip']);
    if (strlen($_POST['ip']) > 64){ $_POST['ip'] = substr($_POST['ip'],0,64); }
    }

if (!empty($_POST['md'])){
    $_POST['md'] = str_replace(" ","",$_POST['md']);
    $_POST['md'] = str_replace("\t","",$_POST['md']);
    if (strlen($_POST['md']) > 64){ $_POST['md'] = substr($_POST['md'],0,64); }
    }

if (!empty($_POST['called'])){
    $_POST['called'] = str_replace(" ","",$_POST['called']);
    $_POST['called'] = str_replace("%20","",$_POST['called']);
    $_POST['called'] = str_replace("\t","",$_POST['called']);
    if (strlen($_POST['called']) > 17){ $_POST['called'] = substr($_POST['called'],0,17); }
    }

if (!empty($_POST['nasid'])){
    $_POST['nasid'] = str_replace(" ","",$_POST['nasid']);
    $_POST['nasid'] = str_replace("\t","",$_POST['nasid']);
    if (strlen($_POST['nasid']) > 6){ $_POST['nasid'] = substr($_POST['nasid'],0,6); }
    }

if (!empty($_POST['userurl'])){
    $_POST['userurl'] = str_replace(" ","",$_POST['userurl']);
    $_POST['userurl'] = str_replace("\t","",$_POST['userurl']);
    if (strlen($_POST['userurl']) > 128){ $_POST['userurl'] = substr($_POST['userurl'],0,128); }
    }

?>
