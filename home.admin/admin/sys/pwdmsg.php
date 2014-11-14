<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>usspoint admin</title>
<link rel="stylesheet" type="text/css" href="/admin/css/global.css" />
<style type="text/css">
#content h2 {
    font-size: 2em;
    margin-bottom: 15px;
}
#alertbox {
  margin: 15px 0 0 0;
}
</style>
</head>

<body>
<div id="header">
<h1>Maintenance</h1>                  
</div>

<div id="content">

<h2>Change Password </h2>
<form action="pwdexec.php" method="POST">  
    <label>Please input new password:</label>
    <br />
    <input type="password" name="passwd1" size="20" value=""> 
    <br />
    <label>Please Retype password:</label>
    <br />
    <input type="password" name="passwd2" size="20" value="">
    <br /><br />
    <input type="submit" value="Set & Relogin"/>  
</form> 


</div>


</body>

</html>
