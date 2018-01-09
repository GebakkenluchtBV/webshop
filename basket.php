<?php
include 'header.php';
require 'database.php';
if (!isset($_SESSION["basket"])) {
  $sql = "INSERT INTO `orders` (`orderedAt`, `status`, `totalPrice`, `customer_id`) VALUES (CURRENT_TIMESTAMP , '0', '0', '".$_SESSION["customer"]["customer_id"]."');";
  if ($conn->query($sql) === TRUE) {
      $_SESSION["basket"] = $conn->insert_id;
  } else {
      echo '<div class="error">Error: '.$sql.'<br>'.$conn->error.'</div>';
  }
}

if (isset($_POST["product_id"]) && isset($_POST["amount"])) {
  $sql = "SELECT * FROM `order_products` NATURAL JOIN `products` WHERE product_id='".$_POST["product_id"]."' AND order_id='".$_SESSION["basket"]."';";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $order_product = $result->fetch_assoc();
    $_POST["order_products_id"] = $order_product["order_products_id"];
    if (($_POST["amount"]+$order_product["amount"]) <= $order_product["amountInStock"]) {
      $_POST["amount"] = $_POST["amount"]+$order_product["amount"];
    } else {
      $_POST["amount"] = $order_product["amountInStock"];
    }
  } else {
    $sql = "INSERT INTO `order_products` (`amount`, `order_id`, `product_id`) VALUES ('".$_POST["amount"]."' , '".$_SESSION["basket"]."', '".$_POST["product_id"]."');";
    if ($conn->query($sql) === TRUE) {
        echo '<div class="success">Product toegevoegd!</div>';
    } else {
        echo '<div class="error">Error: '.$sql.'<br>'.$conn->error.'</div>';
    }
  }
}

if (isset($_POST["order_products_id"]) && isset($_POST["amount"])) {
  if ($_POST["amount"] == 0) {
    $sql = "DELETE FROM `order_products` WHERE order_products_id='".$_POST["order_products_id"]."';";
    if ($conn->query($sql) === TRUE) {
        echo '<div class="success">Product verwijderd!</div>';
    } else {
        echo '<div class="error">Error: '.$sql.'<br>'.$conn->error.'</div>';
    }
  } else {
    $sql = "UPDATE `order_products` SET amount='".$_POST["amount"]."' WHERE order_products_id='".$_POST["order_products_id"]."';";
    if ($conn->query($sql) === TRUE) {
        echo '<div class="success">Product aangepast!</div>';
    } else {
        echo '<div class="error">Error: '.$sql.'<br>'.$conn->error.'</div>';
    }
  }
}

$sql = "SELECT * FROM `orders` NATURAL JOIN `customers` WHERE orders.order_id='".$_SESSION["basket"]."';";
$result = $conn->query($sql);
$sql_products = "SELECT * FROM `order_products` NATURAL JOIN `products` WHERE order_products.order_id='".$_SESSION["basket"]."';";
$products = $conn->query($sql_products);
$totalPrice;

if ($result->num_rows > 0 && $products->num_rows > 0) {
  // output data of each row
  $row = $result->fetch_assoc();
  echo '
    <div class="order-card">
      <h1>Winkelmandje</h1>
      <table class="order-table">
        <thead>
          <tr>
            <th>Artikel</th>
            <th>Aantal</th>
            <th>Per stuk</th>
            <th>Prijs</th>
            <th></th>
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
        <td>
          <form action="/basket.php" method="post">
            <input type="hidden" name="order_products_id" value="'.$item["order_products_id"].'">
            <input type="number" name="amount" value="'.$item["amount"].'" min="0" max="'.$item["amountInStock"].'">
            <button type="submit">Aanpassen</button>
          </form>
        </td>
        <td>€'.($item["price"]/100).'</td>
        <td>€'.(($item["price"]*$item["amount"])/100).'</td>
        <td>
          <form action="/basket.php" method="post">
            <input type="hidden" name="order_products_id" value="'.$item["order_products_id"].'">
            <input type="hidden" name="amount" value="0">
            <button type="submit">Verwijder</button>
          </form>
        </td>
      </tr>
    ';
  }
  echo '
      </table>
      <p><strong>Totale prijs: €'.($totalPrice/100).'</strong></p>
    </div>
  ';
} else {
  echo '
    <div class="basket-card">
      <h1>Je winkelmandje is nog leeg!</h1>
      <p>Ga naar de producten pagina om een artikel aan het winkelmandje toe te voegen</p>
    </div>
  ';
}

$conn->close();

include 'footer.php';
?>
