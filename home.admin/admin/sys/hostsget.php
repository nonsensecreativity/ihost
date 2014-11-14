<html>
<title>gif</title>
<body>
<?php
$str = "sudo cat /etc/hosts";
//echo $str;
$output = shell_exec($str);
//echo "<pre>$output</pre>";
?> 
<form action="hostsset.php" method="POST">  
    <textarea name="if" id="if" cols="80" rows="30">
    <?php
        echo "$output";
    ?>    
    </textarea> 
    <input type="submit" value="Set" />  
</form>  
</body>
</html>
