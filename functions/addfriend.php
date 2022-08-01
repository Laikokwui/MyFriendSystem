<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php
include_once('connectDB.php');

session_start();
if (!isset($_SESSION['id'])) { // if the session is not the same user id
    header("Location: ../index.php"); // logout
    die(); // stop
}
else {
    $uid = $_SESSION['id']; // get user id
}

$fid = $_GET['fid']; // get the friend id

// add in this friend id into the record (add into myfriends table)
$sql = "INSERT INTO myfriends (user_id, friend_id) VALUES ('$uid', '$fid'), ('$fid', '$uid')";    

// test the query above
$query_success = mysqli_query($conn, $sql);

if ($query_success) { // if successful
    // change the value of the num_of_friends in both table
    $query = "UPDATE users t1 JOIN users t2 ON t1.user_id=? AND t2.user_id=? SET t1.num_of_friends = t1.num_of_friends+1, t2.num_of_friends = t2.num_of_friends+1";
    $prepared_stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($prepared_stmt, 'ss', $uid, $fid);
    mysqli_stmt_execute($prepared_stmt);
    $query_result = mysqli_stmt_get_result($prepared_stmt);
    mysqli_stmt_close($prepared_stmt);
    $result_row = mysqli_fetch_assoc($query_result);
    header("Location: ../friendadd.php"); // go to friendadd.php
    die();
}
else {
    echo "<p class=\"error\">Error adding new friends.</p>";
    header("Location: ../friendadd.php");
    die();
}
?>
