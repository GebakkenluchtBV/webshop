<?php
session_start();

require 'database.php';

if (isset($_SESSION["basket"])) {
  $sql = "DELETE FROM `order_products` WHERE order_id='".$_SESSION["basket"]."';";
  $conn->query($sql);
  $sql = "DELETE FROM `orders` WHERE order_id='".$_SESSION["basket"]."';";
  $conn->query($sql);
}
$conn->close();

// remove all session variables
session_unset();

include 'header.php';

echo '<div class="success">Je bent nu uitgelogd.</div>';

include 'footer.php';
?>
