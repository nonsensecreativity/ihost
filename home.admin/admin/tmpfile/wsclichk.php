<?php  
    try{
        $soap = new SoapClient(null,array('location'=>"http://192.168.1.254/auth/auth.php",'uri'=>'auth.php'));
        $result = $soap->getCli($_POST['cid'], $_POST['phone']);
        //echo $_POST['cid']."<br/>";  
        //echo $_POST['phone']."<br/>";  
        //echo $result."<br/>";
        if ($result != 0){
           $flag = 1;
           $base ="central";
           $cid = $_POST['cid'];
           $phone = $_POST['phone'];
           $token = $result;
            }
    }catch(SoapFault $e){
        echo "Warning: ".$e->getMessage() . "<br />";
    }catch(Exception $e){
        echo "Warning: ".$e->getMessage() . "<br />";
    }   
?>
        