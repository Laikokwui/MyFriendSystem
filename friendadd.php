<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php 
include_once('functions/connectDB.php'); // connect to database

include_once('functions/checkSession.php'); // check the session

// Get number of user that is not currently not in this user friend list (prepared statement)
$query = "SELECT * FROM users WHERE user_id NOT IN (SELECT t2.friend_id FROM myfriends t2 WHERE t2.user_id=?) and user_id != ?";
$prepared_stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($prepared_stmt, 'ss', $uid, $uid);
mysqli_stmt_execute($prepared_stmt);
$query_result = mysqli_stmt_get_result($prepared_stmt);
$total_record = mysqli_num_rows($query_result);
mysqli_stmt_close($prepared_stmt);
$result_row = mysqli_fetch_assoc($query_result);

// Get the user id (currently signed in user) (prepared statement)
$query = "SELECT * FROM users WHERE user_id=?";
$prepared_stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($prepared_stmt, 's', $uid);
mysqli_stmt_execute($prepared_stmt);
$query_result = mysqli_stmt_get_result($prepared_stmt);
mysqli_stmt_close($prepared_stmt);
$result_main = mysqli_fetch_assoc($query_result);
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>My Friend System - Add Friend Page</title>
        <meta charset="utf-8"> 
        <meta name="description" content="My Friend System - Add Friend Page">
        <meta name="keywords" content="add friend page, web app assignment 2">
        <meta name="author" content="Lai Kok Wui">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>
            <h1>My Friend System - Add Friend Page</h1>
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
            // limit number of record per page and set the current page
            $total_records_per_page = 5;
            $current_page = 0;
            if (isset($_GET["current_page"])) {
                $current_page=$_GET["current_page"];
            }
            else {
                $current_page = 1;
            }

            $offset=($current_page-1)*05;
            
            // limit number of record per page using the keyword LIMIT
            $query1 = "SELECT * FROM users WHERE user_id NOT IN (SELECT t2.friend_id FROM myfriends t2 WHERE t2.user_id=?) and user_id != ? LIMIT $offset, $total_records_per_page";
            $prepared_stmt1 = mysqli_prepare($conn, $query1);
            mysqli_stmt_bind_param($prepared_stmt1, 'ss', $uid, $uid);
            mysqli_stmt_execute($prepared_stmt1);
            $query_result1 = mysqli_stmt_get_result($prepared_stmt1);
            $total_page = ceil($total_record/$total_records_per_page);
            mysqli_stmt_close($prepared_stmt1);
            
            $table_result = array();
            
            // loop through every record
            while ($row = mysqli_fetch_array($query_result1)) {
                $user_id = $row['user_id']; // get the user id
                // calculate number of mutual friend using COUNT
                $query_mf = "SELECT COUNT(*) As total_mf FROM myfriends AS AM INNER JOIN myfriends AS BM ON (BM.friend_id=AM.friend_id and BM.user_id='$user_id' and BM.friend_id!='$uid') WHERE AM.user_id='$uid' and BM.friend_id!='$user_id'";
                $result_countmf = mysqli_query($conn,$query_mf);
                $total_mf = mysqli_fetch_array($result_countmf);
                $total_mf = $total_mf['total_mf'];

                $table_result[] = 
                    "<tr>
                        <td>".$row['profile_name']."</td>
                        <td>".$total_mf." mutual friend(s)</td>
                        <td><a href=\"functions/addfriend.php?fid=".$row['user_id']."\" title=\"addfriend\">Add as friend</a></td>
                    </tr>
                    ";
            }

            mysqli_close($conn);

            if (mysqli_num_rows($query_result1) != 0) {
                $table = 
                    "<table>
                        <thead>
                            <tr>
                                <th>Profile Name</th>
                                <th>Mutual Friend Count</th>
                                <th>Add as friend</th>
                            </tr>
                        </thead>
                        <tbody>".
                            implode($table_result)
                        ."</tbody>
                     </table>
                     ";
            }
            else {
                $table = "<p class=\"error\">No New Friends!</p>";
            }
            ?>
            <div class="content">
                <h3>
                    My Friend System<br>
                    <?php  echo $result_main['profile_name']; ?>
                    's Friend List Page<br>
                    Total number of friends is 
                    <?php echo $result_main['num_of_friends']; ?>
                </h3>
                <?php 
                echo $table; // display the table
                ?>
                <div class="pagination">
                    <?php
                    if ($current_page>1) {
                        echo " <a href=\"friendadd.php?current_page=".($current_page-1)."\" class=\"previous\">Previous</a> ";
                    }

                    if ((2 <= $current_page) && ($current_page < $total_page)) {
                        for ($page_num=1;$page_num<$total_page;$page_num++) {
                            if ($page_num==$current_page) {
                                echo " <a href=\"friendadd.php?current_page=".$page_num."\" class=\"current\">$page_num</a> ";
                            }
                            else {
                                echo " <a href=\"friendadd.php?current_page=".$page_num."\" class=\"number\">$page_num</a> ";
                            }
                        }
                    }

                    if ($total_page>$current_page) {
                        echo " <a href=\"friendadd.php?current_page=".($current_page+1)."\" class=\"next\">Next</a> ";
                    }
                    ?>
                </div>
                <p>
                    <a href='friendlist.php'>Friends List</a>
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

