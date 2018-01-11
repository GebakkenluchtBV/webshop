<?php
$servername = "localhost";
$username = "gebakkenlucht";
$password = "P@ssw0rd";
$dbname = "gebakkenlucht";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
