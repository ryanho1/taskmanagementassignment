<?php
session_start();
var_dump($_POST);
include "../DB_connection.php"; // Ensure this points to your DB connection file

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = validate_input($_POST['full_name']);
    $username = validate_input($_POST['user_name']); 
    $password = validate_input($_POST['password']);
    $confirm_password = validate_input($_POST['confirm_password']);

    if (empty($full_name) || empty($username) || empty($password) || empty($confirm_password)) {
        $em = "All fields are required";
        header("Location: ../signup.php?error=$em");
        exit();
    }

    if ($password !== $confirm_password) {
        $em = "Passwords do not match";
        header("Location: ../signup.php?error=$em");
        exit();
    }
    //  password security
    if (strlen($password) < 8) {
        $em = "Password too short. Must be at least 8 characters.";
        header("Location: ../signup.php?error=$em");
        exit();
    }
    
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[\W_]/', $password) || !preg_match('/[0-9]/', $password)) {
        $em = "Make it more secure. Password must include at least one capital letter, one symbol, and one number.";
        header("Location: ../signup.php?error=$em");
        exit();
    }

    // Check if the username already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $em = "Username already exists";
        header("Location: ../signup.php?error=$em");
        exit();
    }

    // Encryption
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (full_name, username, password, role) VALUES (?, ?, ?, ?)");
    $role = 'admin'; // Change this to Student when signing up.
    $stmt->bindParam(1, $full_name, PDO::PARAM_STR);
    $stmt->bindParam(2, $username, PDO::PARAM_STR);
    $stmt->bindParam(3, $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(4, $role, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $em = "Account created successfully";
        header("Location: ../login.php?success=$em");
        exit();
    } else {
        $em = "Error: " . implode(", ", $stmt->errorInfo());
        header("Location: ../signup.php?error=$em");
        exit();
    }
}
?>