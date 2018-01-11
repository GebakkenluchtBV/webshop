<?php
include 'header.php';
require 'database.php';

if (isset($_POST["order_id"]) && isset($_POST["totalPrice"])) {
  $sql = "UPDATE `orders` SET status='1', totalPrice='".$_POST["totalPrice"]."' WHERE order_id='".$_POST["order_id"]."';";
  if ($conn->query($sql) === TRUE) {
      echo '<div class="success">Bestelling verzonden!</div>';
      $sql_products = "SELECT * FROM `order_products` NATURAL JOIN `products` WHERE order_products.order_id='".$_SESSION["basket"]."';";
      $products = $conn->query($sql_products);
      if ($products->num_rows > 0) {
        while($item = $products->fetch_assoc()) {
          $sql = "UPDATE `products` SET amountInStock='".($item["amountInStock"]-$item["amount"])."' WHERE product_id='".$item["product_id"]."';";
          if ($conn->query($sql) === !TRUE) {
            echo '<div class="error">Error: '.$sql.'<br>'.$conn->error.'</div>';
          }
        }
      }
      $_SESSION["basket"] = null;
  } else {
    echo '<div class="error">Error: '.$sql.'<br>'.$conn->error.'</div>';
  }
} else if (isset($_SESSION["basket"])) {
  $sql = "SELECT * FROM `orders` NATURAL JOIN `customers` WHERE orders.order_id='".$_SESSION["basket"]."';";
  $result = $conn->query($sql);
  $sql_products = "SELECT * FROM `order_products` NATURAL JOIN `products` WHERE order_products.order_id='".$_SESSION["basket"]."';";
  $products = $conn->query($sql_products);
  $totalPrice;

  if ($result->num_rows > 0 && $products->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
    echo '
      <div class="order-card card">
        <h1>Nieuwe bestelling</h1>
        <p>
          <strong>Besteld op:</strong> '.$row["orderedAt"].'<br>
          <strong>Klant:</strong> '.$row["firstName"].' '.$row["lastName"].'<br>
          <strong>Adres:</strong> '.$row["address"].'<br>
          '.$row["postalCode"].' '.$row["city"].'<br>
          '.$row["country"].'<br>
        </p>
        <h2>Artikelen</h2>
        <table class="order-table">
          <thead>
            <tr>
              <th>Artikel</th>
              <th>Aantal</th>
              <th>Per stuk</th>
              <th>Prijs</th>
            </tr>
          </thead>
    ';
    while($item = $products->fetch_assoc()) {
      $totalPrice += $item["price"]*$item["amount"];
      echo '
        <tr>
          <td>
            <a href="/products/index.php?id='.$item["product_id"].'">
              '.$item["name"].'
            </a>
          </td>
          <td>'.$item["amount"].'</td>
          <td>€'.($item["price"]/100).'</td>
          <td>€'.(($item["price"]*$item["amount"])/100).'</td>
        </tr>
      ';
    }
    echo '
        </table>
        <p><strong>Totale prijs: €'.($totalPrice/100).'</strong></p>
        <form action="/order.php" method="post">
          <input type="hidden" name="order_id" value="'.$row["order_id"].'">
          <input type="hidden" name="totalPrice" value="'.$totalPrice.'">
          <button type="submit">Bestelling afronden</button>
        </form>
      </div>
    ';
  }
} else {
  echo '
    <div class="basket-card card">
      <h1>Je winkelmandje is nog leeg!</h1>
      <p>Ga naar de producten pagina om een artikel aan het winkelmandje toe te voegen</p>
    </div>
  ';
}

$conn->close();

include 'footer.php';
?>
