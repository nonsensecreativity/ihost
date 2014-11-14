<?php
function get_all_headers() { 
$headers = array(); 
foreach($_SERVER as $key => $value) { 
if(substr($key, 0, 5) === 'HTTP_') { 
$key = substr($key, 5); 
$key = strtolower($key); 
$key = str_replace('_', ' ', $key); 
$key = ucwords($key); 
$key = str_replace(' ', '-', $key); 
$headers[$key] = $value; 
} 
} 
return $headers; 
}
    $hdrs = get_all_headers();
    print_r($hdrs);
    echo("<br><br>");
    echo($_GET['mac']);
?> 

