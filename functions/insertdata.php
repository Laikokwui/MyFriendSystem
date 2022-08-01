<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php
// Sanitize data
$email1 = mysqli_escape_string($conn, "jasonlee@gmail.com");
$pwd1 = mysqli_escape_string($conn, "11111111");
$name1 = mysqli_escape_string($conn, "JasonLee");

$email2 = mysqli_escape_string($conn, "poketips@gmail.com");
$pwd2 = mysqli_escape_string($conn, "22222222");
$name2 = mysqli_escape_string($conn, "PokeTips");

$email3 = mysqli_escape_string($conn, "blaine110@gmail.com");
$pwd3 = mysqli_escape_string($conn, "33333333");
$name3 = mysqli_escape_string($conn, "Blaine");

$email4 = mysqli_escape_string($conn, "timmy32@gmail.com");
$pwd4 = mysqli_escape_string($conn, "44444444");
$name4 = mysqli_escape_string($conn, "TimmyBoy");

$email5 = mysqli_escape_string($conn, "yanny@gmail.com");
$pwd5 = mysqli_escape_string($conn, "55555555");
$name5 = mysqli_escape_string($conn, "Laurel");

$email6 = mysqli_escape_string($conn, "dave450@gmail.com");
$pwd6 = mysqli_escape_string($conn, "66666666");
$name6 = mysqli_escape_string($conn, "Dave");

$email7 = mysqli_escape_string($conn, "nemofish@gmail.com");
$pwd7 = mysqli_escape_string($conn, "77777777");
$name7 = mysqli_escape_string($conn, "NemoFish");

$email8 = mysqli_escape_string($conn, "jacky51@gmail.com");
$pwd8 = mysqli_escape_string($conn, "88888888");
$name8 = mysqli_escape_string($conn, "Jacky");

$email9 = mysqli_escape_string($conn, "namewee@gmail.com");
$pwd9 = mysqli_escape_string($conn, "99999999");
$name9 = mysqli_escape_string($conn, "Namewee");

$email10 = mysqli_escape_string($conn, "mailson@gmail.com");
$pwd10 = mysqli_escape_string($conn, "00000000");
$name10 = mysqli_escape_string($conn, "MailsonWei");

// Hash the input password using SHA256
$hpwd1 = hash('sha256', $pwd1);
$hpwd2 = hash('sha256', $pwd2);
$hpwd3 = hash('sha256', $pwd3);
$hpwd4 = hash('sha256', $pwd4);
$hpwd5 = hash('sha256', $pwd5);
$hpwd6 = hash('sha256', $pwd6);
$hpwd7 = hash('sha256', $pwd7);
$hpwd8 = hash('sha256', $pwd8);
$hpwd9 = hash('sha256', $pwd9);
$hpwd10 = hash('sha256', $pwd10);

// Sample records creations for users table
$sql_sampleusers = "INSERT INTO users (user_email, password, profile_name, date_started, num_of_friends) VALUES  
                   ('$email1', '$hpwd1', '$name1', '2020-10-29', '3'), 
                   ('$email2', '$hpwd2', '$name2', '2020-10-31', '2'), 
                   ('$email3', '$hpwd3', '$name3', '2020-10-31', '0'), 
                   ('$email4', '$hpwd4', '$name4', '2020-11-01', '1'), 
                   ('$email5', '$hpwd5', '$name5', '2020-11-02', '1'), 
                   ('$email6', '$hpwd6', '$name6', '2020-11-02', '6'), 
                   ('$email7', '$hpwd7', '$name7', '2020-11-04', '2'), 
                   ('$email8', '$hpwd8', '$name8', '2020-11-06', '2'), 
                   ('$email9', '$hpwd9', '$name9', '2020-11-06', '1'), 
                   ('$email10', '$hpwd10', '$name10', '2020-11-06', '2')";

// Sample records creations for myfriends table
$sql_samplefriends = "INSERT INTO myfriends (user_id, friend_id) VALUES (1,2), (2,1), (1,4), (4,1), (1,6), (6,1), (2,6), (6,2), (5,7), (7,5), (6,7), (7,6), (6,8), (8,6), (6,9), (9,6), (6,10), (10,6), (8,10), (10,8)";

// success or error message 
$userstbmsg = "";
$friendstbmsg = "";

// select all records from users table
$count_users = "SELECT * FROM users"; 
$curesult = mysqli_query($conn, $count_users);

// select all records from myfriends table
$count_myfriends = "SELECT * FROM myfriends"; 
$cmfresult = mysqli_query($conn, $count_myfriends);

// Insert sample records if users table is not empty
if (!$curesult || mysqli_num_rows($curesult) == 0) {
    if (mysqli_query($conn, $sql_sampleusers)) {
        $userstbmsg = "<p class=\"success\">Insert Data into users table Successful!</p>";
    }
    else {
        $userstbmsg = "<p class=\"error\">Unable to insert data into users table!</p>";
    }
}

// Insert sample records if myfriends table is not empty
if (!$cmfresult || mysqli_num_rows($cmfresult) == 0) {
    if (mysqli_query($conn, $sql_samplefriends)) {
        $friendstbmsg = "<p class=\"success\">Insert Data into myfriends table Successful!</p>";
    }
    else {
        $friendstbmsg = "<p class=\"error\">Unable to insert data into myfriends table!</p>";
    }
}
?>
