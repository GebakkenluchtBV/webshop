<?php
include '../header.php';
require '../database.php';

if (isset($_GET['id'])) {
  $sql = "SELECT * FROM `products` NATURAL JOIN `categories` WHERE products.product_id='".$_GET["id"]."';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
      $row = $result->fetch_assoc();
      echo '
        <div class="product-card">
          <h1>'.$row["name"].'</h1>
          <p>'.$row["description"].'</p>
          <p>Prijs: €'.($row["price"]/100).'</p>
          <p>Categorie: '.$row["category"].'</p>
          <p>Voorraad: '.$row["amountInStock"].'</p>
      ';
      if (isset($_SESSION['customer'])) {
        echo '
          <form action="/basket.php" method="post">
            <input type="number" placeholder="Aantal" name="amount" value="1" min="1" max="'.$row["amountInStock"].'" required>
            <input type="hidden" name="product_id" value="'.$row["product_id"].'">
            <button type="submit">Toevoegen aan winkelwagen</button>
          </form>
        ';
      } else {
        echo '
          <p><a href="/login.php">Log in om te bestellen</a></p>
        ';
      }
      echo '
        </div>
      ';
  } else {
    echo "<p>Geen product gevonden</p>";
  }
} else {
  $sql = "SELECT * FROM `products` NATURAL JOIN `categories`;";
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
            <a href="/products/index.php?id='.$row["product_id"].'">Meer informatie</a>
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
