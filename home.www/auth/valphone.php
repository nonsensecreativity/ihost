<?php 
$tel = $_POST['phone'];
if(strlen($tel) == "11") 
{ 
//length
$n = preg_match_all("/13[0123456789]{1}\d{8}|15[012356789]\d{8}|18[56789]{1}\d{8}/",$tel,$array); 

//var_dump($array);  

if ($n == 0){
echo "请重新输入信息<br />Please check your input";
die();
}

}
else{ 
echo "请重新输入信息<br />Please check your input";
die();
} 

?> 

            