<?php
include '../header.php';
require '../database.php';

if (isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["description"]) && isset($_POST["amountInStock"]) && isset($_POST["product_id"])) {
  $sql = "UPDATE `products` SET `name`='".$_POST["name"]."', `price`='".$_POST["price"]."', `description`='".$_POST["description"]."', `amountInStock`='".$_POST["amountInStock"]."' WHERE product_id='".$_POST["product_id"]."';";
  $result = $conn->query($sql);
  if ($result === TRUE) {
      echo "<p>Product aangepast!</p>";
  } else {
      echo "Error creating record: " . $conn->error;
  }
} else if (isset($_GET["id"])){
  $sql = "SELECT * FROM `products` WHERE `product_id`='".$_GET["id"]."';";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
    echo '
      <div class="create-product-card">
        <h1>Product aanpassen</h1>
        <form action="/products/update.php" method="post">
          <label for="name">Naam</label><br>
          <input type="text" value="'.$row["name"].'" name="name" required><br>
          <label for="price">Prijs in centen</label><br>
          <input type="number" value="'.$row["price"].'" name="price" required><br>
          <label for="description">Beschrijving</label><br>
          <textarea name="description" required>'.$row["description"].'</textarea><br>
          <label for="amountInStock">Voorraad</label><br>
          <input type="number" name="amountInStock" min="0" value="'.$row["amountInStock"].'" required><br>
          <input type="hidden" name="product_id" value="'.$row["product_id"].'">
          <button type="submit">Aanpassen</button>
        </form>
      </div>
    ';
  }
} else {
  echo '<p>Geen product gevonden</p>';
}
$conn->close();

include '../footer.php';
?>
