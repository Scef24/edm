<?php
// Include database connection
include_once '../controller/database.php';
include_once '../view/register.php/';
$db = new database(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validate input (add more validation as needed)
    if (empty($username) || empty($email) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
        die("All fields are required");
    }

    if ($_POST['password'] !== $_POST['confirm_password']) {
        die("Passwords do not match");
    }

    // Insert user into database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // Registration successful, redirect to login page or dashboard
        header("Location:/login.php"); 
        exit();
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
