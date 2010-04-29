<?php 
ini_set('error_reporting', E_ALL);
error_reporting(-1);
$connx = mysql_connect("localhost", "webuser", "familymath");
if(!$connx)
{
   die("DB connection failed: " . mysql_error());
}else{
   echo "connected successfully";
}
?> 