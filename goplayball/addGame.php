<?php 
session_start();

if (!isset($_SESSION["uid"])) header("Location: ../index.php");

$location = "localhost";
$username = "webuser";
$password = "familymath";
$database = "goplayball";

$conn = mysql_connect("$location", "$username", "$password");
if (!$conn) die ("Could not connect MySQL");
mysql_select_db($database, $conn) or die ("Could not open database");

$gamewon = mysql_real_escape_string($_POST["gamewon"]);
$rbi = mysql_real_escape_string($_POST['rbi']);
$runs = mysql_real_escape_string($_POST['runs']);
$walks = mysql_real_escape_string($_POST['walks']);
$pa = mysql_real_escape_string($_POST['pa']);
$hits = mysql_real_escape_string($_POST['hits']);
$date = mysql_real_escape_string($_POST['date']);
$opponent = mysql_real_escape_string($_POST['opponent']);
$team = mysql_real_escape_string($_POST['team']);
$uid = mysql_real_escape_string($_SESSION['uid']);

echo mysql_query("insert into `baseball_games` (`id`, `uid`, `team`, `opponent`, `date`, `hits`, `pa`, `walks`, `runs`, `rbi`, `gamewon`) values (NULL, \"$uid\", \"$team\", \"$opponent\", \"$date\", \"$hits\", \"$pa\", \"$walks\", \"$runs\", \"$rbi\", \"$gamewon\");");

?>
