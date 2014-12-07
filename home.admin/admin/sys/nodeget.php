<html>
<title>nodename</title>
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
    <label>MAC: <?php echo $mac; ?></label><br />
    <input type="hidden" name="mac" size="36" value="<?php echo $mac; ?>"> 
    <br /> 
    <label>IP: <?php echo $ip; ?></label><br />      
    <input type="hidden" name="ip" size="64" value="<?php echo $ip; ?>">
    <br /> 
    <label>Report Type: </label><br />
    <label>'start' for at the beginning; 'end' for at the end; 'mid' for at the middle</label><br />
    <label>of a work procedure</label><br />
    <input type="text" name="rpttype" size="36" value="<?php echo $rpttype; ?>">
    <br />  
    <label>Application Type: 'ma' for meeting affair; 'ms' for automobile station; ''</label><br />
    <label>'ma' for meeting affair; 'ms' for automobile station; 'hr' for human resource</label><br />
    <label>'other' for other application type</label><br />
    <input type="text" name="apptype" size="36" value="<?php echo $apptype; ?>">
    <br /> 
	<label>Database file import at the beginning: (github url)</label><br />
    <input type="text" name="dbinput" size="128" value="<?php echo $dbinput; ?>">
    <br /> 
    <label>Datebase file export at the end: (github url)</label><br />
    <input type="text" name="dboutput" size="128" value="<?php echo $dboutput; ?>">
    <br /> 
    <label>Location: street name or building name </label><br />
    <input type="text" name="location" size="64" value="<?php echo $location; ?>">
    <br /> 
    <label>Company: company name of the location</label><br />
    <input type="text" name="company" size="64" value="<?php echo $company; ?>">
    <br /> 
    <label>Owner: owner of the ihost</label><br />
    <input type="text" name="owner" size="64" value="<?php echo $owner; ?>">
    <br /> 
    <label>Latitude: latitude of the location</label><br />
    <input type="text" name="latitude" size="36" value="<?php echo $latitude; ?>">
    <br /> 
    <label>Longitude: longitude of the location </label><br />
    <input type="text" name="longitude" size="36" value="<?php echo $longitude; ?>">
    <br /> 
    <label>Administrator: administrator name of the ihost</label><br />
    <input type="text" name="admin" size="36" value="<?php echo $admin; ?>">
    <br /> 
    <label>Contact: contact info of the administrator</label><br />
    <input type="text" name="contact" size="64" value="<?php echo $contact; ?>">
    <br /> 
    <label>Memo: </label><br />
    <input type="text" name="memo" size="128" value="<?php echo $memo; ?>">
    <br /> 
    <br />
    <input type="submit" value="set"/>
    
          
</form>  
</body>

