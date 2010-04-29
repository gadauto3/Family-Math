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

$win = mysql_real_escape_string($_POST['gamewon']);
$rbi = mysql_real_escape_string($_POST['rbi']);
$runs = mysql_real_escape_string($_POST['runs']);
$obp = mysql_real_escape_string($_POST['obp']);
$ba = mysql_real_escape_string($_POST['ba']);
$date = mysql_real_escape_string($_POST['date']);
$opponent = mysql_real_escape_string($_POST['opponent']);
$name = mysql_real_escape_string($_POST['name']);
$uid = mysql_real_escape_string($_SESSION['uid']);

$query = "insert into `mlb` (`uid`, `name`, `opponent`, `date`, `ba`, `obp`, `runs`, `rbi`, `win`) values (\"$uid\", \"$name\", \"$opponent\", \"$date\", \"$ba\", \"$obp\", \"$runs\", \"$rbi\", \"$win\")";
$result = mysql_query($query);
echo mysql_affected_rows();
?>