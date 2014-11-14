<?php  
    try{
        $soap = new SoapClient(null,array('location'=>"http://192.168.1.254/auth/server.php",'uri'=>'server.php'));
        $result = $soap->getCli("130302197111221234", "13933036200");
        echo $result."<br/>";
        if ($result == 1){
           $flag = 1;
           $base ="central";
            }
    }catch(SoapFault $e){
        echo $e->getMessage();
    }catch(Exception $e){
        echo $e->getMessage();
    }   
?>

