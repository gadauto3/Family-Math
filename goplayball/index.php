<?php 
   
session_start();
//session_destroy();
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
include 'printers.php';
$error = "";


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
	$firstname = mysql_real_escape_string($_POST["firstname"]);
	$lastname = mysql_real_escape_string($_POST["lastname"]);
	$firstname = strtolower($_POST["firstname"]);
	$lastname = strtolower($_POST["lastname"]);
	if(strlen($firstname) < 1 || strlen($firstname) > 20) {
		$error .= "<p class='error'>First name must be between 1 and 20 characters.</p>";
	}

	if(strlen($lastname) < 1 || strlen($lastname) > 30) {
		$error .= "<p class='error'>Last name must be between 1 and 30 characters.</p>";
	}

	if(!preg_match("/^[a-z ]+$/", $firstname) || !preg_match("/^[a-z ]+$/", $lastname)) {
		$error .= "<p class='error'>First and last names must be letters and spaces only.</p>";
	}

	if(isset($_POST["team"])) {
		$team = strtolower($_POST["team"]);
		$team = mysql_real_escape_string($team);
		if(!preg_match("/^[a-z ]+$/", $team)) {
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
	if(!is_numeric($_SESSION["uid"])) {
		die("Fatal Error: UID is not numeric");
	}
	$result = mysql_query("select * from `baseball_games` where `uid` = {$_SESSION['uid']} order by `date`");
	if (mysql_num_rows($result)) {
		while ($r = mysql_fetch_array($result)) {
			echo "gameData.push(new Array(\"$r[3]\", \"$r[4]\", $r[5], $r[6], $r[7], $r[8], $r[9], $r[10]));\n";
		}
	}

	echo "var MLB = new Array();";

	$result = mysql_query("select distinct `name` from `mlb` where `uid` = {$_SESSION['uid']}");
	if (mysql_num_rows($result)) {
		while ($r = mysql_fetch_array($result)) {
			echo "MLB.push('$r[0]');";
		}
	}
	echo "</script>";

?><script> currentScreen = "SeasonStats";</script> <?php 
	include 'main.php';
	//include 'login.php';
} else {
	echo "<script>";
	echo "var gameData = null;</script>\n";
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
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-527454-7");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>

</html>