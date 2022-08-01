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

// delete the record for this user id friend with this user id. (delete from myfriends table)
$sql = "DELETE FROM myfriends WHERE user_id='$uid' and friend_id='$fid' or user_id='$fid' and friend_id='$uid'";    

// test the query above
$query_success = mysqli_query($conn, $sql);

// if successful execute
if ($query_success) {
    // change the value of num_of_friends (prepared statement)
    $query = "UPDATE users t1 JOIN users t2 ON t1.user_id=? AND t2.user_id=? SET t1.num_of_friends = t1.num_of_friends-1, t2.num_of_friends = t2.num_of_friends-1";
    $prepared_stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($prepared_stmt, 'ss', $uid, $fid);
    mysqli_stmt_execute($prepared_stmt);
    $query_result = mysqli_stmt_get_result($prepared_stmt);
    mysqli_stmt_close($prepared_stmt);
    $result_row = mysqli_fetch_assoc($query_result);
    header("Location: ../friendlist.php"); // go to friendlist.php
    die();
}
else {
    echo "<p class=\"error\">Error removing friends.</p>";
    header("Location: ../friendlist.php");
    die();
}
?>
