<?php
include '../header.php';
require '../database.php';

if (isset($_GET['id'])) {
  $sql = "SELECT * FROM `products` JOIN `categories` ON `products`.`category_id` = `categories`.`id` WHERE products.id='".$_GET["id"]."';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '
          <div class="product-card">
            <h1>'.$row["name"].'</h1>
            <p>'.$row["description"].'</p>
            <p>Prijs: €'.($row["price"]/100).'</p>
            <p>Categorie: '.$row["category"].'</p>
          </div>
        ';
      }
  } else {
    echo "<p>Geen product gevonden</p>";
  }
} else {
  $sql = "SELECT * FROM `products` JOIN `categories` ON `products`.`category_id` = `categories`.`id`;";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '
          <div class="product-card">
            <h1>'.$row["name"].'</h1>
            <p>'.$row["description"].'</p>
            <p>Prijs: €'.($row["price"]/100).'</p>
            <p>Categorie: '.$row["category"].'</p>
            <a href="/products/index.php?id='.$row["id"].'">Meer informatie</a>
          </div>
        ';
      }
  } else {
    echo "<p>Geen producten gevonden</p>";
  }
}
$conn->close();

include '../footer.php';
?>
