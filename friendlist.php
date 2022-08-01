<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php 
include_once('functions/connectDB.php'); // connect to database

include_once('functions/checkSession.php'); // check session

// Get the user id (currently signed in user) (prepared statement)
$query = "SELECT * FROM users WHERE user_id=?";
$prepared_stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($prepared_stmt, 's', $uid);
mysqli_stmt_execute($prepared_stmt);
$query_result = mysqli_stmt_get_result($prepared_stmt);
mysqli_stmt_close($prepared_stmt);
$result_row = mysqli_fetch_assoc($query_result);
?> 

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>My Friend System - Friend List Page</title>
        <meta charset="utf-8"> 
        <meta name="description" content="My Friend System - Friend List Page">
        <meta name="keywords" content="friend list page, web app assignment 2">
        <meta name="author" content="Lai Kok Wui">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>
            <h1>My Friend System - Friend List Page</h1>
        </header>
        <div class="header_nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </div>
        <article class="friend">
            <?php
            // select user that is in your friendlist (prepared statement)
            $query1 = "SELECT * FROM myfriends t2 INNER JOIN users t1 ON t2.friend_id = t1.user_id WHERE t2.user_id=?";
            $prepared_stmt1 = mysqli_prepare($conn, $query1);
            mysqli_stmt_bind_param($prepared_stmt1, 's', $uid);
            mysqli_stmt_execute($prepared_stmt1);
            $query_result1 = mysqli_stmt_get_result($prepared_stmt1);
            mysqli_stmt_close($prepared_stmt1);
            
            $table_result = array();
            
            // loop through all the record to construct the table
            while ($row = mysqli_fetch_array($query_result1)) {
                $table_result[] = 
                    "<tr>
                        <td>".$row['profile_name']."</td>
                        <td>".$row['num_of_friends']." friend(s)</td>
                        <td><a href=\"functions/unfriend.php?fid=".$row['user_id']."\" title=\"Unfriend\">Unfriend</a></td>
                    </tr>
                    ";
            }
            mysqli_close($conn);

            if (mysqli_num_rows($query_result1) == 0) {
                $table = "<p class='error'>You have no friends currently.</p>";
            }
            else {
                $table = 
                    "<table>
                        <thead>
                            <tr>
                                <th>Profile Name</th>
                                <th>Friend Count</th>
                                <th>Unfriend</th>
                            </tr>
                        </thead>
                        <tbody>".
                            implode($table_result)
                        ."</tbody>
                     </table>
                     ";
            }
            ?>
            <div class="content">
                <h3>
                    My Friend System<br>
                    <?php  echo $result_row['profile_name']; ?>
                    's Friend List Page<br>
                    Total number of friends is 
                    <?php echo $result_row['num_of_friends']; ?>
                </h3>
                <?php echo $table; ?>
                <p>
                    <a href='friendadd.php'>Add Friends</a>
                    <a href='logout.php' class="logout">Log Out</a>
                </p>
            </div>
        </article>
        <footer>
            <ul class="footer_nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </footer>
    </body>
</html>
