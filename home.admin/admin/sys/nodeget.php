<html>
<title>nodename</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<body>
<?php
 
$str = "sudo  ifconfig eth0 | grep 'eth0'  |  sed 's/ \{2,\}/ /g'";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode(' ', $output);
$mac=$myArray[4];

$str = "sudo  ifconfig eth0 | grep 'inet addr:'"; 
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode(':', $output);
$ipArray=explode(' ',$myArray[1]); 
$ip=$ipArray[0];

$str = "sudo  cat  /root/node  | grep rpttype=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$rpttype=$myArray[1];

$str = "sudo  cat  /root/node  | grep apptype=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$apptype=$myArray[1];

$str = "sudo  cat  /root/node  | grep dbinput=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$dbinput=$myArray[1];

$str = "sudo  cat  /root/node  | grep dboutput=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$dboutput=$myArray[1];

$str = "sudo  cat  /root/node  | grep location=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$location=$myArray[1];

$str = "sudo  cat  /root/node  | grep company=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$company=$myArray[1];

$str = "sudo  cat  /root/node  | grep owner=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$owner=$myArray[1];

$str = "sudo  cat  /root/node  | grep latitude=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$latitude=$myArray[1];

$str = "sudo  cat  /root/node  | grep longitude=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$longitude=$myArray[1];

$str = "sudo  cat  /root/node  | grep admin=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$admin=$myArray[1];

$str = "sudo  cat  /root/node  | grep contact=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$contact=$myArray[1];

$str = "sudo  cat  /root/node  | grep memo=";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
$myArray = explode('=', $output);
$memo=$myArray[1];
?> 

<form action="nodeset.php" method="POST">  
    <label style="font-weight:bold;font-size:12px;">MAC: <?php echo $mac; ?></label><br />
    <input type="hidden" name="mac" size="36" value="<?php echo $mac; ?>">  
    <label style="font-weight:bold;font-size:12px;">IP: <?php echo $ip; ?></label><br />      
    <input type="hidden" name="ip" size="64" value="<?php echo $ip; ?>">
    <br /> 
    <label style="font-weight:bold;font-size:12px;">Report Type: </label><br />
    <label style="font-size:12px;">'start' for at the beginning; 'end' for at the end; 'mid' for at the middle</label><br />
    <label style="font-size:12px;">of a work procedure</label><br />
    <input type="text" name="rpttype" size="36" value="<?php echo $rpttype; ?>">
    <br /> 
    <label style="font-weight:bold;font-size:12px;">Application Type: </label><br />
    <label style="font-size:12px;">'ma' for meeting affair; 'ms' for automobile station; 'hr' for human resource</label><br />
    <label style="font-size:12px;">'other' for other application type</label><br />
    <input type="text" name="apptype" size="36" value="<?php echo $apptype; ?>">
    <br />
	<label style="font-weight:bold;font-size:12px;">Database file import at the beginning: (github url)</label><br />
    <input type="text" name="dbinput" size="128" value="<?php echo $dbinput; ?>">
    <br />
    <label style="font-weight:bold;font-size:12px;">Datebase file export at the end: (github url)</label><br />
    <input type="text" name="dboutput" size="128" value="<?php echo $dboutput; ?>">
    <br />
    <label style="font-weight:bold;font-size:12px;">Location: street name or building name </label><br />
    <input type="text" name="location" size="64" value="<?php echo $location; ?>">
    <br /> 
    <label style="font-weight:bold;font-size:12px;">Company: company name of the location</label><br />
    <input type="text" name="company" size="64" value="<?php echo $company; ?>">
    <br />
    <label style="font-weight:bold;font-size:12px;">Owner: owner of the ihost</label><br />
    <input type="text" name="owner" size="64" value="<?php echo $owner; ?>">
    <br />
    <label style="font-weight:bold;font-size:12px;">Latitude: latitude of the location</label><br />
    <input type="text" name="latitude" size="36" value="<?php echo $latitude; ?>">
    <br />
    <label style="font-weight:bold;font-size:12px;">Longitude: longitude of the location </label><br />
    <input type="text" name="longitude" size="36" value="<?php echo $longitude; ?>">
    <br />
    <label style="font-weight:bold;font-size:12px;">Administrator: administrator name of the ihost</label><br />
    <input type="text" name="admin" size="36" value="<?php echo $admin; ?>">
    <br />
    <label style="font-weight:bold;font-size:12px;">Contact: contact info of the administrator</label><br />
    <input type="text" name="contact" size="64" value="<?php echo $contact; ?>">
    <br /> 
    <label style="font-weight:bold;font-size:12px;">Memo: </label><br />
    <input type="text" name="memo" size="128" value="<?php echo $memo; ?>">
    <br /> 
    <br />
    <input type="submit" value="set"/>
    
          
</form>  
</body>

