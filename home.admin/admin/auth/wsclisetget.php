<html>
<title>gif</title>
<body>
<?php
$str = "sudo cat /var/www/auth/wscliset.php";
//echo $str;
$output = shell_exec($str);
?> 
<form action="wsclisetset.php" method="POST">  
    <textarea name="if" id="if" cols="110" rows="30">
    <?php
        echo "$output";
    ?>
    </textarea> 
    <input type="submit" value="Set" />  
</form> 

</body>
</html>
