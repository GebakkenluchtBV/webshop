<?php
// Start the session
session_start();

$isAdmin = false;
if (isset($_SESSION["customer"])) {
  $isAdmin = $_SESSION["customer"]["isAdmin"];
}
?>
<!DOCTYPE html>
<html lang="en">

	<head>
	<meta charset="utf-8">

	<title>Gebakken Lucht</title>
	<meta name="Welcome to a webshop that sells air!" content="Gebakken Lucht">
	<meta name="Gebakken Lucht, Luchtkasteel, Special Air" content="Gebakken Lucht webshop">

	<link rel="stylesheet" type="text/css" href="/styles/stylesheet.css"/>

	</head>

	<body>

	<div class ="main">


		<div class="header">

			<img class="header-image" src="/images/voor_achter.jpg">

		</div>

		<div class="titlebar">
      <nav>

			<a class="nav-item" href="/index.php">
				Home
			</a>

			<a class="nav-item" href="/products">
				Producten
			</a>

<?php

if (isset($_SESSION["customer"])) {
	if ($_SESSION["customer"]["isAdmin"]) {
		echo '
			<a class="nav-item" href="/customers">
				Klanten
			</a>
		';
	}
	echo '
		<a class="nav-item" href="/customers/index.php?id='.$_SESSION["customer"]["customer_id"].'">
			Account
		</a>

		<a class="nav-item" href="/orders">
			Bestellingen
		</a>
	';
	if (isset($_SESSION["basket"])) {
		echo '
			<a class="nav-item basket" href="/basket.php">
				Winkelmandje
			</a>
		';
	}
	echo '
		<a class="nav-item" href="/logout.php">
			Uitloggen
		</a>
	';
} else {
	echo '
		<a class="nav-item" href="/login.php">
			Inloggen
		</a>
	';
}

?>
      </nav>
		</div>

		<div class="content">
