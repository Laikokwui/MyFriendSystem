<!--
Name: Lai Kok Wui
Student ID: 101211447
Date: 20 November 2020
-->

<?php 
// run code from connectDB.php which help connect to the database
include_once('functions/connectDB.php');

// for storing error message
$errors = ""; // all the error
$error1 = ""; // empty fill
$error2 = ""; // invalid email
$error3 = ""; // email taken
$error4 = ""; // Invalid Profile name
$error5 = ""; // Profile name Taken
$error6 = ""; // invalid password
$error7 = ""; // confirm password not match password

if (isset($_POST['submit'])) {
    // for validation checking
    $validation = true;
    
    // user input's value
    $email = mysqli_escape_string($conn, $_POST['email']);
    $name = mysqli_escape_string($conn, $_POST['name']);
    $pwd = mysqli_escape_string($conn, $_POST['pwd']);
    $cpwd = mysqli_escape_string($conn, $_POST['cpwd']);
    
    // Check any input is empty
    if (empty($email) || empty($name) || empty($pwd) || empty($cpwd)) {
        $error1 = "<p class=\"error\">Fill in all the fill!</p>";
        $validation = false;
    }
    else { // continue if everything is filled
        // using FILTER_VALIDATE_EMAIL Filter to check the email is valid or not
        if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || (strlen($email) > 50)) { // if it is not valid
            $error2 = "<p class=\"error\">Invalid Email!<br>Maximum 50 characters for the email!</p>";
            $validation = false;
        }
        else { // if the email is valid
            // check email has been registered
            $sql_chkemail = "SELECT * FROM users WHERE user_email = '$email'";
            $query_chkemail = mysqli_query($conn, $sql_chkemail);
            if (mysqli_num_rows($query_chkemail) > 0) { // if email is registed
                $error3 = "<p class='error'>This email has been registered!</p>";
            }
        }
        
        // check profile name/ username is valid or not
        $namepattern = "/^[a-zA-Z]{1,30}$/";
        if (!preg_match($namepattern, $name)) { // if name doesn't match the regex (only letters allowed)
            $error4 = "<p class=\"error\">Only Letters can be used as Profile Name!<br>With No Space allowed!<br>Maximum 30 characters!</p>";
            $validation = false;
        }

        // check profile name is unique or not
        $sql_chkname = "SELECT * FROM users WHERE profile_name = '$name'";
        $query_chkname = mysqli_query($conn, $sql_chkname);
        if (mysqli_num_rows($query_chkname) > 0) { // if profile name has been registed
            $error5 = "<p class=\"error\">Profile Name has been taken!</p>";
            $validation = false;
        }
        
        // check profile name/ username is valid or not
        $pwdpattern = "/^[a-zA-Z0-9]{1,20}$/";
        if (!preg_match($pwdpattern, $pwd)) { // if password doesn't match the regex (only letters and numbers allowed)
            $error6 = "<p class=\"error\">Only Letters and Numbers can be used as Password!<br>With No Space allowed!<br>Maximum 20 characters!</p>";
            $validation = false;
        }

        // check password is it matching
        if ($pwd !== $cpwd) { // if it is not match
            $error7 = "<p class=\"error\">Password and confirm password doesn't match!</p>";
            $validation = false;
        }
    }
    
    // check user inputs are valid or not
    if ($validation) { 
        // today's date according to the system
        $date = date("Y-m-d");
        // hash password SHA-256 
        $hpwd = hash('sha256', $pwd);
        // insert data
        $sql_newuser = "INSERT INTO users (user_email, password, profile_name, date_started, num_of_friends) VALUES ('$email', '$hpwd', '$name', '$date', '0')";
        $query_success = mysqli_query($conn, $sql_newuser);
        // if added successfully
        if ($query_success) {
            // get user id from database (prepared statement)
            $query = "SELECT * FROM users WHERE user_email=?";
            $prepared_stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($prepared_stmt, 's', $email);
            mysqli_stmt_execute($prepared_stmt);
            $query_result = mysqli_stmt_get_result($prepared_stmt);
            mysqli_stmt_close($prepared_stmt);
            $result_row = mysqli_fetch_assoc($query_result);

            //echo $_SESSION['id'];
            session_start(); 
            $_SESSION['id'] = $result_row['user_id'];
            header("Location: friendadd.php");
            die();
        }
    }
    else { // invalid user inputs
        $errors="<div class=\"message\">".$error1.$error2.$error3.$error4.$error5.$error6.$error7."</div>";
    }
}
?> 

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>My Friend System - Sign Up Page</title>
        <meta charset="utf-8"> 
        <meta name="description" content="My Friend System - Registration Page">
        <meta name="keywords" content="registration page, web app assignment 2">
        <meta name="author" content="Lai Kok Wui">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>
            <h1>My Friend System - Registration Page</h1>
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
            <form action = "#" method="POST">
                <h2>Sign Up</h2>
                <label for="email">Email: </label><br>
                <input type="text" id="email" name="email"><br>
                
                <label for="name">Profile Name: </label><br>
                <input type="text" id="name" name="name"><br>
                
                <label for="pwd">Password: </label><br>
                <input type="password" id="pwd" name="pwd"><br>
                
                <label for="cpwd">Comfirm Password: </label><br>
                <input type="password" id="cpwd" name="cpwd"><br>
                <p class="buttons">
                    <button type="submit" value="submit" name="submit">Register</button>
                    <button type="reset" value="reset" name="reset">Clear</button>
                </p>
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
