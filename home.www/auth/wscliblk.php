<?php
    $passwd = "1234567890";
    $secret = "ab";        
    $cred = crypt($passwd,$secret);
    //$strmixid = "'130324197110046316-13333510020-963450267','130324197110046316-13333510020-963450268'";
    $strmixid = $_GET['strmixid'];
    //echo $strmixid.<br />;
    if ($strmixid == ""){
        echo "-1";
    }
    else{
        try{
            $soap = new SoapClient(null,array('location'=>"http://192.168.1.254/auth/auth.php",'uri'=>'auth.php'));
            $result = $soap->setBlk($cred, $_SERVER ['HTTP_HOST'], "zgbdh001", $strmixid);  
            echo $result;
            if ($result != 0){                     
                echo "Warning: block central authclient failed!<br />";
            }   
        }catch(SoapFault $e){
            echo "Warning: ".$e->getMessage() . "<br />";
        }catch(Exception $e){
            echo "Warning: ".$e->getMessage() . "<br />";
        }
    }
?>

