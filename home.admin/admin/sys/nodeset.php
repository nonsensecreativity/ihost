<html>
<title>cdns</title>
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
$location = $_POST['location'];
$company = $_POST['company'];
$owner = $_POST['owner'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$admin = $_POST['admin'];
$contact = $_POST['contact'];
$memo = $_POST['memo'];

$strline1 = "mac="  . $mac;
$strline1 = $strline1 . "\nip="  . $ip;
$strline1 = $strline1 . "\nrpttype="  . $rpttype;
$strline1 = $strline1 . "\napptype="  . $apptype;
$strline1 = $strline1 . "\ndbinput="  . $dbinput;
$strline1 = $strline1 . "\ndboutput="  . $dboutput;
$strline1 = $strline1 . "\nlocation="  . $location;
$strline1 = $strline1 . "\ncompany="  . $company;
$strline1 = $strline1 . "\nowner="  . $owner;
$strline1 = $strline1 . "\nlatitude="  . $latitude;
$strline1 = $strline1 . "\nlongitude="  . $longitude;
$strline1 = $strline1 . "\nadmin="  . $admin;
$strline1 = $strline1 . "\ncontact="  . $contact;
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

/*
// Push ihost node info to iserver
echo "<br />Push to iserver... <br />";
$url = "http://182.92.195.40:8080/";
$url = $url . "face-detection/detection/123/";

// Initialize the cURL session with the request URL
$session = curl_init($url);
//echo $session;

// Tell cURL to return the request data
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// Set the HTTP request authentication headers
$headers = array("content-type":"application/json;charset=UTF-8");
print $headers;
curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

// Execute cURL on the session handle
$response = curl_exec($session);

// Close the cURL session
curl_close($session);

echo $response . "<br />";
echo "<br />";
echo "Remote Done! <br />";

*/
?> 
</body>
</html>
