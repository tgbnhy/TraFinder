<?php
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username. 
define("PASSWORD", "tgbnhy");    // The database password. 
define("DATABASE", "project");    // The database name.
 
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$mysqli->set_charset("utf8");
if(mysqli_connect_errno()) {
  echo "Connection Failed: " . mysqli_connect_errno();
  exit();
}
?>
