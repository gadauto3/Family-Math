<?php 
session_start();

if (!isset($_SESSION["uid"])) header("Location: ../index.php");

$location = "localhost";
$username = "cas951";
$password = "arctulis";
$database = "cas951_familymath";

$conn = mysql_connect("$location", "$username", "$password");
if (!$conn) die ("Could not connect MySQL");
mysql_select_db($database, $conn) or die ("Could not open database");

$gamewon = $_POST["gamewon"];
$query = "insert into `mlb` (`uid`, `name`, `opponent`, `date`, `ba`, `obp`, `runs`, `rbi`, `win`) values (\"{$_SESSION['uid']}\", \"{$_POST['name']}\", \"{$_POST['opponent']}\", \"{$_POST['date']}\", \"{$_POST['ba']}\", \"{$_POST['obp']}\", \"{$_POST['runs']}\", \"{$_POST['rbi']}\", \"$gamewon\")";
$result = mysql_query($query);
echo mysql_affected_rows();
?>