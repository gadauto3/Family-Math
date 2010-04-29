<?php 
session_start();

$_SESSION["uid"] = 3;
?>
<form action="addMLB.php" method="POST">

<input name="name" value="Jason">
<input name="gamewon" value="1">
<input name="opponent" value="Them">
<input name="date" value="1984-12-24">
<input name="ba" value="0.6">
<input name="obp" value="0.5">
<input name="runs" value="5">
<input name="rbi" value="3">
<input type="submit">
</form>