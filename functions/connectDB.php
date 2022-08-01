<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "101211447";

$conn = @mysqli_connect($host, $user, $password) or die('<p>Error connecting to database!</p>'); // Create DB connection object
@mysqli_select_db($conn, $db) or die ('<p>Error selecting database!</p>'); // Select DB
?>
