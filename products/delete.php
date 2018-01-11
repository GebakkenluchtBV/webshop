<?php
include '../header.php';
require '../database.php';

if (isset($_GET['id']) && $isAdmin) {
  $sql = "SELECT * FROM `products` WHERE product_id='".$_GET["id"]."';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  // output data of each row
    $row = $result->fetch_assoc();
    echo '
      <div class="delete-product-card card">
        <h1>Weet je zeker dat je dit product wil verwijderen?</h1>
        <p><strong>Product: </strong>'.$row["name"].'</strong></p>
        <form action="/products/delete.php" method="post">
          <input type="hidden" name="product_id" value="'.$row["product_id"].'">
          <button type="submit">Definitief verwijderen</button>
        </form>
      </div>
    ';
  } else {
    echo '<div class="error">Geen product gevonden</div>';
  }
} else if (isset($_POST['product_id']) && $isAdmin) {
  $sql = "DELETE FROM `products` WHERE product_id='".$_POST["product_id"]."';";
  $result = $conn->query($sql);
  if ($result === TRUE) {
      echo '<div class="success">Product verwijderd!</div>';
  } else {
      echo '<div class="error">Error deleting record: ' . $conn->error . '</div>';
  }
} else {
  echo '<div class="error">Geen product gevonden</div>';
}
$conn->close();

include '../footer.php';
?>
