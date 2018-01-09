<?php
include '../header.php';
require '../database.php';
$status = array("In winkelwagen", "Besteld", "Betaald", "Verwerkt", "Verzonden", "Geannuleerd");
if (isset($_GET['id'])) {
  $sql = "SELECT * FROM `orders` NATURAL JOIN `customers` WHERE orders.order_id='".$_GET["id"]."';";
  $result = $conn->query($sql);
  $sql_products = "SELECT * FROM `order_products` NATURAL JOIN `products` WHERE order_products.order_id='".$_GET["id"]."';";
  $products = $conn->query($sql_products);

  if ($result->num_rows > 0) {
    // output data of each row
      $row = $result->fetch_assoc();
        echo '
          <div class="order-card">
            <h1>Bestelling</h1>
            <p>
              <strong>Nummer:</strong> '.$row["order_id"].'<br>
              <strong>Besteld op:</strong> '.$row["orderedAt"].'<br>
              <strong>Status:</strong> '.$status[$row["status"]].'<br>
              <strong>Bedrag:</strong> €'.($row["totalPrice"]/100).'<br>
              <strong>Klant: </strong>
              <a href="/customers/index.php?id='.$row["customer_id"].'">
               '.$row["firstName"].' '.$row["lastName"].'
              </a>
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
        if ($products->num_rows > 0) {
          while($item = $products->fetch_assoc()) {
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
        }
        echo '
            </table>
          </div>
        ';
  } else {
    echo "<p>Geen bestelling gevonden</p>";
  }
} else {
  $sql;
  if ($_SESSION["customer"]["isAdmin"]) {
    $sql = "SELECT * FROM `orders` NATURAL JOIN `customers`;";
  } else {
    $sql = "SELECT * FROM `orders` NATURAL JOIN `customers` WHERE NOT status='0' AND customer_id='".$_SESSION["customer"]["customer_id"]."';";
  }
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    echo '
    <h1>Bestellingen</h1>
    <table class="orders-table">
      <thead>
        <tr>
          <th>Nummer</th>
          <th>Besteld op</th>
          <th>Status</th>
          <th>Bedrag</th>
          <th>Klant</th>
        </tr>
      </thead>
    ';
      while($row = $result->fetch_assoc()) {
        echo '
          <tr>
            <td>
              <a href="/orders/index.php?id='.$row["order_id"].'">
                '.$row["order_id"].'
              </a>
            </td>
            <td>'.$row["orderedAt"].'</td>
            <td>'.$status[$row["status"]].'</td>
            <td>€'.($row["totalPrice"]/100).'</td>
            <td>
              <a href="/customers/index.php?id='.$row["customer_id"].'">
                '.$row["firstName"].' '.$row["lastName"].'
              </a>
            </td>
          </tr>
        ';
      }
    echo '</table>';
  } else {
    echo "<p>Geen bestellingen gevonden</p>";
  }
}
$conn->close();

include '../footer.php';
?>
