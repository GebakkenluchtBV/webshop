<?php
session_start();
$error = null;

require 'database.php';
if (isset($_POST["username"]) && isset($_POST["password"])) {
  $sql = "SELECT * FROM `customers` WHERE username='".$_POST["username"]."';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
    if ($customer["password"] == $_POST["password"]) {
      $_SESSION["customer"] = $customer;
    } else {
      $error = 'Wachtwoord incorrect';
    }
  } else {
    $error = 'Klant niet gevonden';
  }
}

include 'header.php';

if (isset($_SESSION["customer"])) {
  echo '<div class="success">Welkom '.$_SESSION["customer"]["firstName"].'! Je bent nu ingelogd.</div>';
} else {
  if ($error) {
    echo '<div class="error">'.$error.'</div>';
  }
  echo '
    <div class="login-card">
      <h1>Inloggen</h1>
      <form action="/login.php" method="post">
        <label>Gebruikersnaam:</label><br>
        <input type="text" placeholder="Gebruikersnaam" name="username" required><br>

        <label>Wachtwoord:</label><br>
        <input type="password" placeholder="Wachtwoord" name="password" required><br>

        <button type="submit">Login</button>
      </form>
    </div>
  ';
}

include 'footer.php';
?>
