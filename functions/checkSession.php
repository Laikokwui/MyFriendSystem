<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php
session_start();
if (!isset($_SESSION['id'])) { // if this is 
    header("Location: index.php");
    die();
}
else {
    $uid = $_SESSION['id'];
}
?>
