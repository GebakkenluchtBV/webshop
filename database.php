<?php
$servername = "192.168.179.128";
$username = "gebakkenlucht";
$password = "P@ssw0rd";

try {
  $database = new PDO("mysql:host=$servername;dbname=gebakkenlucht", $username, $password);
  // set the PDO error mode to exception
  $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
