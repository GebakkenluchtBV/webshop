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
        <div class="customer-card card">
          <h1>Klant</h1>
          <p>
            <strong>Voornaam:</strong> '.$row["firstName"].'<br>
            <strong>Achternaam:</strong> '.$row["lastName"].'<br>
            <strong>Adres:</strong> '.$row["address"].'<br>
            <strong>Postcode:</strong> '.$row["postalCode"].'<br>
            <strong>Plaats:</strong> '.$row["city"].'<br>
            <strong>Land:</strong> '.$row["country"].'<br>
            <strong>Telefoonnummer:</strong> '.$row["phoneNumber"].'<br>
            <strong>IBAN:</strong> '.$row["IBAN"].'<br>
            <strong>Rekeninghouder:</strong> '.$row["IBANholder"].'<br>
            <strong>Gebruikersnaam:</strong> '.$row["username"].'<br>
          </p>
        </div>
      ';
  } else {
    echo '<div class="error">Geen klant gevonden</div>';
  }
} else {
  $sql = "SELECT * FROM `customers`;";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    echo '
    <div class="customers-card card">
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
    echo '</table></div>';
  } else {
    echo '<div class="error">Geen klanten gevonden</div>';
  }
}
$conn->close();

include '../footer.php';
?>
