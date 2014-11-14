<html>
<title>gtime</title>
<body>
<script type="text/javascript">   
function gettime() {     
    return Math.round((+new Date)/1000);
}   
var timestr = Math.round(Date.now/1000) || gettime();  
timestr = timestr + 2;
location.href="timeset.php?timestr="+timestr;
//alert(location.href);
</script>  
</body>

