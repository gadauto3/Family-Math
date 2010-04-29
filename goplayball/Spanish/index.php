<?php 
   
//session_start();
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
include 'printers.php';
$error = "";

$firstname = strtolower($_POST["firstname"]);
$lastname = strtolower($_POST["lastname"]);
$location = "localhost";
$username = "cas951";
$password = "arctulis";
$database = "cas951_familymath";

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

if (isset($_POST["firstname"], $_POST["lastname"])) {
	if (strlen($firstname) < 1 || strlen($firstname) > 20) {
		$error .= "<p class='error'>First name must be between 1 and 20 characters.</p>";
	}

	if (strlen($lastname) < 1 || strlen($lastname) > 30) {
		$error .= "<p class='error'>Last name must be between 1 and 30 characters.</p>";
	}

	if (!preg_match("^[a-z ]+$", $firstname) || !preg_match("^[a-z ]+$", $lastname)) {
		$error .= "<p class='error'>First and last names must be letters and spaces only.</p>";
	}

	if (isset($_POST["team"])) {
		$team = strtolower($_POST["team"]);
		if (!preg_match("^[a-z ]+$", $team)) {
			$error .= "<p class='error'>Team name must be letters and spaces only.</p>";
		}

		$result = mysql_query("select uid from `users` where firstname = \"{$firstname}\" and lastname = \"{$lastname}\";");
		if (mysql_num_rows($result) > 0) {
			$error .= "<p class='error'>User name is already taken.</p>";
		}

		if ($error == "") {
			$result = mysql_query("insert into `users` (`uid`, `uname`, `pass`, `firstname`, `lastname`, `image`, `team`) values (NULL, " . 
			"\"aaa\", \"bbb\", \"{$firstname}\", \"{$lastname}\", \"none.jpg\", \"{$team}\");");

			if (mysql_affected_rows() == -1) {
				$error .= "<p class='error'>Unexpected database error. Please try again later.</p>";
			} else {
				$result = mysql_query("select uid from `users` where firstname = \"{$firstname}\" and lastname = \"{$lastname}\";");
				$r = mysql_fetch_array($result);
				$_SESSION["uid"] = $r[0];
			}
		}
	} else {
		if ($error == "") {
			$result = mysql_query("select uid from `users` where firstname = \"{$firstname}\" and lastname = \"{$lastname}\";");
			if (mysql_num_rows($result) > 0) {
				$r = mysql_fetch_array($result);
				$_SESSION["uid"] = $r[0];
			} else {
				$error = "<p class='error'>Error: user name does not match any records.</p>";
			}
		}
	}
}		

if (isset($_SESSION["uid"])) {
	echo "<script>";
	echo "var gameData = new Array();";

	$result = mysql_query("select * from `baseball_games` where `uid` = {$_SESSION['uid']} order by `date`");
	if (mysql_num_rows($result)) {
		while ($r = mysql_fetch_array($result)) {
			echo "gameData.push(new Array(\"$r[3]\", \"$r[4]\", $r[5], $r[6], $r[7], $r[8], $r[9], $r[10]));";
		}
	}

	echo "var MLB = new Array();";

	$result = mysql_query("select distinct `name` from `mlb` where `uid` = {$_SESSION['uid']}");
	if (mysql_num_rows($result)) {
		while ($r = mysql_fetch_array($result)) {
			echo "MLB.push('$r[0]');";
		}
	}

?>
<script> currentScreen = "SeasonStats";</script> <?php 
	include 'main.php';
} else {
	include 'login.php';
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