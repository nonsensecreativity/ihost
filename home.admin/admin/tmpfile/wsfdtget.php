<?php
$url = "http://192.168.1.252:8080/";
$url = $url . "face-detection/detection/123/";
//$url = $url . "driver_license";
$url = $url . $imgname . "/";
//$namepart = explode(".", $imgname);
//$url = $url . $namepart[0]; 
//echo $url . "<br />";

// Initialize the cURL session with the request URL
$session = curl_init($url); 
//echo $session;

// Tell cURL to return the request data
curl_setopt($session, CURLOPT_RETURNTRANSFER, true); 

// Set the HTTP request authentication headers
$headers = array(
    'user: ' . 'qhd',
    'password: ' . 'detecti$3',
    'metadata: ' . 'face-detection'
);
curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

// Execute cURL on the session handle
$response = curl_exec($session);

// Close the cURL session
curl_close($session);

//echo $response . "<br />";

?>
        