<?php
session_start();
// remove all session variables
session_unset();

include 'header.php';

echo '<div class="success">Je bent nu uitgelogd.</div>';

include 'footer.php';
?>
