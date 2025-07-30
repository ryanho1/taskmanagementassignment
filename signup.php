<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signupcss.css"> 
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <?php
        // Display any error or success messages
        if (isset($_GET['error'])) {
            echo "<p class='error'>" . htmlspecialchars($_GET['error']) . "</p>";
        }
        if (isset($_GET['success'])) {
            echo "<p class='success'>" . htmlspecialchars($_GET['success']) . "</p>";
        }
        ?>
        <form action="app/signup_process.php" method="POST" class="form-1">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" class="input-1" required placeholder="your full name here">

            <label for="username">Username:</label>
            <input type="text" name="user_name" id="user_name" class="input-1" required placeholder="your username here">

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="input-1" required placeholder="your password here">

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" class="input-1" required placeholder="Double check it">

            <div class="button-group">
            <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
            <button type="button" class="btn btn-primary" onclick="window.location.href='login.php'">Login</button></div>
        </form>
    </div>
</body>
</html>