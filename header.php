<?php
// Start the session
session_start();
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

		 <!-- Header image moet zo breed zijn als de main (600px breed). -->

			<img class="header-image" src="/images/voor_achter.jpg">

		</div>

		<div class="titlebar">

			<a href="/index.php">
				Home
			</a>

			<a href="/products">
				Producten
			</a>

<?php

if (isset($_SESSION["customer"])) {
	if ($_SESSION["customer"]["isAdmin"]) {
		echo '
			<a href="/customers">
				Klanten
			</a>
		';
	}
	echo '
		<a href="/customers/index.php?id='.$_SESSION["customer"]["customer_id"].'">
			Account
		</a>

		<a href="/orders">
			Bestellingen
		</a>
	';
	if (isset($_SESSION["basket"])) {
		echo '
			<a href="/basket.php">
				Winkelmandje
			</a>
		';
	}
	echo '
		<a href="/logout.php">
			Uitloggen
		</a>
	';
} else {
	echo '
		<a href="/login.php">
			Inloggen
		</a>
	';
}

?>

		</div>

		<div class="content">
