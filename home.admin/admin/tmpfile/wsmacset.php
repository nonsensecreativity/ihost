<?php
    $passwd = "1234567890";
    $secret = "ab";        
    $cred = crypt($passwd,$secret);
    try{
        $soap = new SoapClient(null,array('location'=>"http://192.168.1.254/auth/auth.php",'uri'=>'auth.php'));
        $result = $soap->setMac($cred, $_SERVER ['HTTP_HOST'],"zgbdh001", $_POST['mac'], $_POST['ip'], $_POST['cid'], $_POST['phone'],$_POST['token']);
        //echo $result."<br/>";
        if ($result != 0){                     
            echo "Warning: update central authlist failed!<br />";
        }   
    }catch(SoapFault $e){
        echo "Warning: ".$e->getMessage() . "<br />";
    }catch(Exception $e){
        echo "Warning: ".$e->getMessage() . "<br />";
    }
?>
        