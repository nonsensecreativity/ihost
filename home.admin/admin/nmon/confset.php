<html>
<title>sif</title>
<body>
<?php
$ifstr=$_POST['if'];
//echo $ifstr;
$fpath = "/opt/id-images/admin/tmpfile/";
$fname = "configact.xml";
$str = "touch " . $fpath . $fname;
//echo $str;
$output = shell_exec($str);
echo "<pre>$output</pre>";
$file = fopen($fpath . $fname,"w");
echo fwrite($file,$ifstr);
fclose($file);
$str = "sudo cp " . $fpath . $fname . "  /root/configact.xml";
//echo $str;
$output = shell_exec($str);
echo "<pre>$output</pre>";
?>
</body>

