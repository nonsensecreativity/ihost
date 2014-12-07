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
$rpttype = $_POST['rpttyep'];
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
$strline2 = "ip="  . $ip;
$strline3 = "rpttype="  . $rpttype;
$strline4 = "apptype="  . $apptype;
$strline5 = "dbinput="  . $dbinput;
$strline6 = "dboutput="  . $dboutput;
$strline7 = "location="  . $location;
$strline8 = "company="  . $company;
$strline9 = "owner="  . $owner;
$strline10 = "latitude="  . $latitude;
$strline11 = "longitude="  . $longitude;
$strline12 = "admin="  . $admin;
$strline13 = "contact="  . $contact;
$strline14 = "memo="  . $memo;

$str = "sudo sed -i '1s/.*/" . $strline1  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '2s/.*/" . $strline2  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '3s/.*/" . $strline3  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '4s/.*/" . $strline4  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo sed -i '5s/.*/" . $strline5  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";
$str = "sudo sed -i '6s/.*/" . $strline6  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";
$str = "sudo sed -i '7s/.*/" . $strline7  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";
$str = "sudo sed -i '8s/.*/" . $strline8  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";
$str = "sudo sed -i '9s/.*/" . $strline9  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";
$str = "sudo sed -i '10s/.*/" . $strline10  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";
$str = "sudo sed -i '11s/.*/" . $strline11  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";
$str = "sudo sed -i '12s/.*/" . $strline12  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";
$str = "sudo sed -i '13s/.*/" . $strline13  . "/' " . $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";
$str = "sudo sed -i '14s/.*/" . $strline14  . "/' " . $orgpath . $orgname;
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



