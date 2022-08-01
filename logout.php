<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php
if (isset($_SESSION['id'])) {
    session_unset(); // Free all session variables
    session_destroy(); // Destroys all data registered to a session
} 
header('Location: index.php'); // direct to home page
?>
