<html>
<title>cdns</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<body>
<?php
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "node";
$orgpath = "/root/";
$orgname = "node";

$mac = $_POST['mac'];   
$ip = $_POST['ip']; 
$rpttype = $_POST['rpttype'];
$apptype = $_POST['apptype'];
$dbinput = $_POST['dbinput'];
$dboutput = $_POST['dboutput'];
$city = $_POST['city'];
$location = $_POST['location'];
$company = $_POST['company'];
$owner = $_POST['owner'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$admin = $_POST['admin'];
$phone = $_POST['phone'];
$wechatid = $_POST['wechatid'];
$memo = $_POST['memo'];

$strline1 = "mac="  . $mac;
$strline1 = $strline1 . "\nip="  . $ip;
$strline1 = $strline1 . "\nrpttype="  . $rpttype;
$strline1 = $strline1 . "\napptype="  . $apptype;
$strline1 = $strline1 . "\ndbinput="  . $dbinput;
$strline1 = $strline1 . "\ndboutput="  . $dboutput;
$strline1 = $strline1 . "\ncity="  . $city;
$strline1 = $strline1 . "\nlocation="  . $location;
$strline1 = $strline1 . "\ncompany="  . $company;
$strline1 = $strline1 . "\nowner="  . $owner;
$strline1 = $strline1 . "\nlatitude="  . $latitude;
$strline1 = $strline1 . "\nlongitude="  . $longitude;
$strline1 = $strline1 . "\nadmin="  . $admin;
$strline1 = $strline1 . "\nphone="  . $phone;
$strline1 = $strline1 . "\nwechatid="  . $wechatid;
$strline1 = $strline1 . "\nmemo="  . $memo;

//echo $strline1 . "<br />";

$str = "sudo echo \"" . $strline1  . "\" > " . $fpath . $fname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo cp "  . $fpath . $fname . " "  . $orgpath . $orgname;    
//echo $str;
$output = shell_exec($str);
//echo "<br />";


echo "<br />";
echo "Local Done! <br />";

$str = "sudo  cat  " . $orgpath . $orgname ;
$output = shell_exec($str);
echo "<pre>$output</pre>";


// Push ihost node info to iserver
echo "<br />Push to iserver... <br />";
$url = "http://182.92.195.40:8080/";
$url = $url . "ihostloc";

// Initialize the cURL session with the request URL
$session = curl_init($url);
//echo $session;

// Tell cURL to return the request data
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// Set the HTTP request headers
$headers = array("Content-Type: application/json;charset=UTF-8");
//print_r($headers);
//echo "<br />";
curl_setopt($session, CURLOPT_HTTPHEADER, $headers);


// Prepare payload
$payload = array("id" => 0,
                                 "mac" => $mac,
                                 "priip" => $ip,
                                 "pubip" => null,
                                 "rpttype" => $rpttype,
                                 "apptype" => $apptype,
                                 "dbinput" => $dbinput,
                                 "dboutput" => $dboutput,
                                 "city" => $city,
                                 "location" => $location,
                                 "company" => $company,
                                 "owner" => $owner,
                                 "latitude" => $latitude,
                                 "longitude" => $longitude,
                                 "admin" => $admin,
                                 "phone" => $phone,
                                 "wechatid" => $wechatid,
                                 "memo" => $memo,
                                 "progid" => "php manual"
                                 );

//print_r($payload);
//echo "<br />";
//echo json_encode($payload,JSON_UNESCAPED_UNICODE);

// Set the HTTP request payload
curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($payload,JSON_UNESCAPED_UNICODE));

// Execute cURL on the session handle
$response = curl_exec($session);
$httpcode = curl_getinfo($session, CURLINFO_HTTP_CODE);
// Close the cURL session
curl_close($session);

//echo $response . "<br />";
echo "<br /><br />";
if ($httpcode == 201) {
    echo "Success!";
}
else {
    echo "FAILED!";  
}

?> 
</body>
</html>
