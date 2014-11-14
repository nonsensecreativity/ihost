<html>
<title>usspoint</title>
<body>
<script type="text/javascript">
seconds = 3;

function decreaseTime(){
  document.hotspot_login_form.button.value="Please wait : " + seconds;
  seconds--;
  if(seconds<0){
    document.hotspot_login_form.button.value='   ¼ÌÐø   Go   ';
    document.hotspot_login_form.button.disabled=false;
    return true;
  }
  setTimeout('decreaseTime()',1000);
}

window.onload = function() {
  document.hotspot_login_form.button.value="Please wait : " + seconds; ;
  setTimeout('decreaseTime()',1000);
}
</script>

<script type="text/javascript" src="md5.js"></script>
<script type="text/javascript" src="hotspot.js"></script>
<h3>Welcome to Hotspot</h3></center>
<img src="ruckus.jpg" />
<?php
include "orgchkpost.php";
?>

<div style= 'font-size: 12px;'>

<form name="hotspot_login_form" method="get" action="http://<?php echo $_POST['uamip']; ?>:<?php echo $_POST['uamport']; ?>/login" 
      onsubmit="return hotspot_login('<?php echo $_POST['challenge']; ?>')">

<input type="hidden" name="userurl" value="<?php echo $_POST['userurl']; ?>">
<input type="hidden" name="response">
<input type="hidden" name="username" size="20" value="usr1" maxlength="128">
<br />
<input type="hidden" name="temp_password" size="20" value="password" maxlength="128">
<br />
<input type="submit" name="button" value=""  disabled >
</form>

</div>
</body>
</html>  
