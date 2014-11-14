<?php
    $passwd = "1234567890";
    $secret = "ab";        
    $cred = crypt($passwd,$secret);
    try{
        $soap = new SoapClient(null,array('location'=>"http://192.168.1.254/auth/sms.php",'uri'=>'sms.php'));
        $result = $soap->rcv2db($cred, $_SERVER ['HTTP_HOST'],"zgbdh001", "123456", "111111111");
        echo $result."<br/>";
        if ($result != 0){                     
            echo "Error: Send SMS failed!<br />";
        }   
    }catch(SoapFault $e){
        echo "Warning: ".$e->getMessage() . "<br />";
    }catch(Exception $e){
        echo "Warning: ".$e->getMessage() . "<br />";
    }
?>
