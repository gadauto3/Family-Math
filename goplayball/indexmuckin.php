<?php 
   
session_start();
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
include 'printers.php';
$error = "Hello";


$location = "localhost";
$username = "webuser";
$password = "familymath";
$database = "goplayball";

$conn = mysql_connect("$location", "$username", "$password");
if (!$conn) die ("Could not connect MySQL");
mysql_select_db($database, $conn) or die ("Could not open database");

?>
<html>

<head>
 <title>Go Play Ball!</title>
 <link rel="stylesheet" type="text/css" href="main.css" />
 <script type="text/javascript" src="navigate.js"></script>
 <script type="text/javascript" src="validate.js"></script>
 <script type="text/javascript" src="calculate.js"></script>
</head>

<body>

<?php 

if(isset($_POST["firstname"], $_POST["lastname"])) {
	echo "hello";
	$firstname = strtolower($_POST["firstname"]);
	$lastname = strtolower($_POST["lastname"]);
}		

if (isset($_SESSION["uid"])) {
	include 'main.php';
	$error = "uid is set";
} else {
	include 'login.php';
	$error = "uid is not set";
}

?>

<table id="Alert" style="position:absolute; top:0px; left:0px;"><tr><td align="center" valign="MIDDLE" style="width:320px; height:180px; border:none; display:block;">
&nbsp;
<div id="AlertText" style="position:absolute; left:55px; width:200px; background:#bbbbbb; border:1px solid #ffffff;">Loading...</div>
</td></tr></table>
<script>document.getElementById("Alert").style.display = "none"; calculateStats(); getYears(); populateList(); populateMLBList(); setStart();</script>
<?php if ($error != "") { ?>
<script>
document.getElementById("AlertText").innerHTML = "<?php echo $error; ?>" + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
document.getElementById("Alert").style.display = "block";
</script>
<?php } ?>

</body>

</html>