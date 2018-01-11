<?php
include '../header.php';
require '../database.php';

if (isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["description"]) && isset($_POST["amountInStock"]) && isset($_POST["category_id"])) {
  $sql = "INSERT INTO `products` (`name`, `price`, `description`, `amountInStock`, `category_id`) VALUES ('".$_POST["name"]."', '".$_POST["price"]."', '".$_POST["description"]."', '".$_POST["amountInStock"]."', '".$_POST["category_id"]."');";
  $result = $conn->query($sql);
  if ($result === TRUE) {
      echo '<div class="success">Product aangemaakt!</div>';
  } else {
      echo '<div class="error">Error creating record: ' . $conn->error . '</div>';
  }
} else {
  $sql = "SELECT * FROM `categories`;";
  $result = $conn->query($sql);

  echo '
    <div class="create-product-card card">
      <h1>Product aanmaken</h1>
      <form action="/products/create.php" method="post">
        <label for="name">Naam</label><br>
        <input type="text" name="name" required><br>
        <label for="price">Prijs in centen</label><br>
        <input type="number" name="price" required><br>
        <label for="description">Beschrijving</label><br>
        <textarea name="description" required></textarea><br>
        <label for="amountInStock">Voorraad</label><br>
        <input type="number" name="amountInStock" min="1" required><br>
        <label for="category_id">Categorie</label><br>
        <select name="category_id">
  ';
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo '<option value="'.$row["category_id"].'">'.$row["category"].'</option>';
    }
  } else {
    echo '<option value="1">Onbekend</option>';
  }
  echo '
        </select><br>
        <button type="submit">Aanmaken</button>
      </form>
    </div>
  ';
}
$conn->close();

include '../footer.php';
?>
