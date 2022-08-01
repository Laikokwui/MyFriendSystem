<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php
// configuration
$host = "localhost";
$user = "root";
$password = "";
$db = "101211447";

// messages to indicate success or failed
$tb1output = "";
$tb2output = "";
$dboutput = "";

// Create DB connection object
$conn = @mysqli_connect($host, $user, $password) or die('<p class=\"error\">Error connecting to database!</p>'); 

// create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `101211447` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"; 

if (mysqli_query($conn, $sql)) { // if query statement successfully run
    // Select and connect to my database
    @mysqli_select_db($conn, $db) or die ('<p class=\"error\">Error selecting database!</p>');
    // save the successful message
    $dboutput = "<p class=\"success\">Database is created successful!</p>";
}
else { // if query statement failed
    // save the failed message
    $dboutput = "<p class=\"error\">Cannot create Database!</p>";
}

// create users table if not exist
$query1 = "CREATE TABLE IF NOT EXISTS `users` (
        `user_id` INT NOT NULL AUTO_INCREMENT,
        `user_email` VARCHAR(50) NOT NULL,
        `password` VARCHAR(256) NOT NULL,
        `profile_name` VARCHAR(30) NOT NULL,
        `date_started` DATE NOT NULL,
        `num_of_friends` INT UNSIGNED,
        PRIMARY KEY (`user_id`),
        UNIQUE(`user_email`),
        UNIQUE(`profile_name`)
)";

// create myfriends table
$query2 = "CREATE TABLE IF NOT EXISTS `myfriends` (
    `user_id` INT NOT NULL,
    `friend_id` INT NOT NULL,
    FOREIGN KEY(`user_id`) REFERENCES users(`user_id`),
    FOREIGN KEY(`friend_id`) REFERENCES users(`user_id`),
    UNIQUE(`user_id`,`friend_id`)
)";

// check users table query statement is working
if (mysqli_query($conn, $query1)) {
    $tb1output = "<p class=\"success\">users table is created successful!</p>";
}
else { // query statement fail to create users table
    $tb1output = "<p class=\"error\">Cannot create users table!</p>";
}

// check myfriends table query statement is working
if (mysqli_query($conn, $query2)) {
    $tb2output = "<p class=\"success\">myfriends table is created successful!</p>";
}
else { // query statement fail to create myfriends table
    $tb2output = "<p class=\"error\">Cannot create myfriends table!</p>";
}

// run code from insertdata.php which help insert all the preloaded data
include_once('functions/insertdata.php');
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>My Friend System - Home Page</title>
        <meta charset="utf-8">
        <meta name="description" content="My Friend System - home Page">
        <meta name="keywords" content="home page, web app assignment 2">
        <meta name="author" content="Lai Kok Wui">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>
            <h1>My Friend System - Home Page</h1>
        </header>
        <div class="header_nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </div>
        <article class="home">
            <div class="disclaimer">
                <h2>Home</h2>
                <p>
                    Name: Lai Kok Wui<br>
                    Student ID: 101211447<br>
                    Email Address: 101211447@students.swinburne.edu.my
                </p>
                <p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student’s work or from any other source.</p>
            </div>
            <div class="message">
                <?php
                echo $dboutput;
                echo $tb1output;
                echo $tb2output;
                ?>
            </div>
            <?php
            if (($userstbmsg != "")||($friendstbmsg != "")) {
                echo "<div class=\"message\">".$userstbmsg;
                echo $friendstbmsg."</div>";
            }
            ?>
        </article>
        <footer>
            <ul class="footer_nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </footer>
    </body>
</html>
