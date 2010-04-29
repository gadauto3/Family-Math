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
echo mysql_query("insert into `baseball_games` (`id`, `uid`, `team`, `opponent`, `date`, `hits`, `pa`, `walks`, `runs`, `rbi`, `gamewon`) values (NULL, \"{$_SESSION['uid']}\", \"{$_POST['team']}\", \"{$_POST['opponent']}\", \"{$_POST['date']}\", \"{$_POST['hits']}\", \"{$_POST['pa']}\", \"{$_POST['walks']}\", \"{$_POST['runs']}\", \"{$_POST['rbi']}\", \"$gamewon\");");

?>
