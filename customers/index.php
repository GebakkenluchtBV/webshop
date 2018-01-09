<?php
include '../header.php';
require '../database.php';

if (isset($_GET['id'])) {
  $sql = "SELECT * FROM `customers` WHERE customer_id='".$_GET["id"]."';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
      $row = $result->fetch_assoc();
      echo '
        <div class="customer-card">
          <h1>Klant</h1>
          <ul>
            <li><strong>Voornaam:</strong> '.$row["firstName"].'</li>
            <li><strong>Achternaam:</strong> '.$row["lastName"].'</li>
            <li><strong>Adres:</strong> '.$row["address"].'</li>
            <li><strong>Postcode:</strong> '.$row["postalCode"].'</li>
            <li><strong>Plaats:</strong> '.$row["city"].'</li>
            <li><strong>Land:</strong> '.$row["country"].'</li>
            <li><strong>Telefoonnummer:</strong> '.$row["phoneNumber"].'</li>
            <li><strong>IBAN:</strong> '.$row["IBAN"].'</li>
            <li><strong>Rekeninghouder:</strong> '.$row["IBANholder"].'</li>
            <li><strong>Gebruikersnaam:</strong> '.$row["username"].'</li>
          </ul>
        </div>
      ';
  } else {
    echo "<p>Geen klant gevonden</p>";
  }
} else {
  $sql = "SELECT * FROM `customers`;";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    echo '
    <h1>Klanten</h1>
    <table class="customers-table">
      <thead>
        <tr>
          <th>Naam</th>
          <th>Adres</th>
          <th>Postcode</th>
          <th>Plaats</th>
        </tr>
      </thead>
    ';
      while($row = $result->fetch_assoc()) {
        echo '
          <tr>
            <td>
              <a href="/customers/index.php?id='.$row["customer_id"].'">
                '.$row["firstName"].' '.$row["lastName"].'
              </a>
            </td>
            <td>'.$row["address"].'</td>
            <td>'.$row["postalCode"].'</td>
            <td>'.$row["city"].'</td>
          </tr>
        ';
      }
    echo '</table>';
  } else {
    echo "<p>Geen klanten gevonden</p>";
  }
}
$conn->close();

include '../footer.php';
?>
