<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php 
// connect to the database
include_once('functions/connectDB.php');

// initialise the error message
$errors = "";
$error1 = "";
$error2 = "";
$error3 = ""; 

if (isset($_POST['submit'])) {
    $validation = true;
    $email = mysqli_escape_string($conn, $_POST['email']);
    $pwd = mysqli_escape_string($conn, $_POST['pwd']);
    
    if (empty($email) || empty($pwd)) {
        $error1 = "<p class=\"error\">Please complete all the fields above.</p>";
        $validation = false; 
    }
    else {
        // query to get the record by email
        $statement1 = "SELECT * FROM users WHERE user_email=?";
        
        // prepare statement
        $prepared_stmt = mysqli_prepare($conn, $statement1);
        
        // statement
        mysqli_stmt_bind_param($prepared_stmt, 's', $email);
        
        // execute the query
        mysqli_stmt_execute($prepared_stmt);
        
        // get the result
        $query_result = mysqli_stmt_get_result($prepared_stmt);
        
        // close the statement
        mysqli_stmt_close($prepared_stmt);
        
        // check email is registed in the system
        if (!$query_result || mysqli_num_rows($query_result) == 0) { // if it is not
            $error2 = "<p class=\"error\">The account doesn't exist. Enter a different email or get a new one.</p><p><a href=\"signup.php\">Click here to register</a></p>";
            $validation = false;
        }
        else { // if it is exist
            $hpwd = hash('sha256', $pwd); // hash the password so can do comparison with the hash password in the database
            $result_row = mysqli_fetch_assoc($query_result); // get the record from database
            if ($result_row['password'] !== $hpwd) { // compare password (if it is not exist)
                $error3 = "<p class=\"error\">Login failed!<br>Your email and/or password do not match.</p>";
                $validation = false; 
            }
        }
    }
    
    // check whetehr it has any error
    if ($validation) { // if no error
        session_start(); // start the session
        $_SESSION['id'] = $result_row['user_id']; // get the user id
        header("Location: friendlist.php"); // go to friendlist.php
        die(); // stop this page
    }
    else { // if there error (at least one)
        $errors="<div class=\"message\">".$error1.$error2.$error3."</div>"; // compile all the error into errors
    }
}
?> 

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>My Friend System - Login Page</title>
        <meta charset="utf-8"> 
        <meta name="description" content="My Friend System - Login Page">
        <meta name="keywords" content="login page, web app assignment 2">
        <meta name="author" content="Lai Kok Wui">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>
            <h1>My Friend System - Login Page</h1>
        </header>
        <div class="header_nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </div>
        <article class="form">
            <form action="#" method="POST">
                <h2>Login</h2>
                <label for="email">Email: </label><br>
                <input type="text" id="email" name="email"><br>

                <label for="pwd">Password: </label><br>
                <input type="password" id="pwd" name="pwd"><br>
                <div class="buttons">
                    <button type="submit" value="submit" name="submit">Log in</button>
                    <button type="reset" value="reset" name="reset">Clear</button>
                </div>
            </form>
            <?php echo $errors; ?>
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

