<html>
<title>cdns</title>
<body>
<?php
$orgpath = "/etc/chilli/";
$orgname = "defaults";
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "defaults";

$olddomain="HS_UAMDOMAINS=\"" . $_POST['olddomain'];
$olddomain =  substr($olddomain,0,strlen($olddomain)-2);
$olddomain = $olddomain . "\"";

$domain="HS_UAMDOMAINS=\"" . $_POST['domain'] . "\"";

$str = "sudo sed 's/" . $olddomain  . "/" . $domain   . "/g'  " . $orgpath . $orgname . " > " . $fpath . $fname;
//echo $str;
$output = shell_exec($str);
//echo "<br />";

$str = "sudo cp " .  $fpath . $fname  . "  " .  $orgpath . $orgname;
//echo $str;
$output = shell_exec($str);  

echo "<br />";

echo "Done! <br />";

$str = "sudo  cat /etc/chilli/defaults | grep HS_UAMDOMAINS=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$domain=$myArray[1];

echo "<br />";
echo "Domains allowed : " . $domain . "<br />";


?> 
</body>

