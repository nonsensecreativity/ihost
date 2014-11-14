<html>
<title>Online Clients</title>
<body>

<?php

//
$str = "sudo python /root/getonline.py";
//echo $str;
$output = shell_exec($str);
$output = str_replace("get client-info","",$output);
$output = str_replace("Jrkscli:","",$output); 
$output = str_replace("Unknown","",$output);   
$output = str_replace("summary:","",$output);  

echo "<pre>$output</pre>";
echo "<p></p>";
echo "<a href=/index.html>Back to index</a>";

?> 
</body>
