<?php
include '../header.php';
require '../database.php';

if (isset($_GET['id'])) {
  $sql = "SELECT * FROM `orders` NATURAL JOIN `customers` WHERE orders.order_id='".$_GET["id"]."';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '
          <div class="order-card">
            <h1>Bestelling</h1>
            <ul>
              <li><strong>Nummer:</strong> '.$row["order_id"].'</li>
              <li><strong>Besteld op:</strong> '.$row["orderedAt"].'</li>
              <li><strong>Status:</strong> '.$row["status"].'</li>
              <li><strong>Bedrag:</strong> '.$row["totalPrice"].'</li>
              <li><strong>Klant: </strong>
                <a href="/customers/index.php?id='.$row["customer_id"].'">
                 '.$row["firstName"].' '.$row["lastName"].'
                </a>
              </li>
            </ul>
          </div>
        ';
      }
  } else {
    echo "<p>Geen bestelling gevonden</p>";
  }
} else {
  $sql = "SELECT * FROM `orders` NATURAL JOIN `customers`;";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    echo '
    <h1>Bestellingen</h1>
    <table class="customers-table">
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
            <td>'.$row["status"].'</td>
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
