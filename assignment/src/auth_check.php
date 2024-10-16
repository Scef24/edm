<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        // Add a debug message to check if this function is being called
   //     error_log("User not logged in, redirecting to login page");
        header('Location: /xampp/assignment/public/view/login.php');
        exit();
    }
    // Add a debug message when the user is logged in
  //  error_log("User is logged in");
}

// Add a new function to set the logged_in session variable
function setLoggedIn($value = true) {
    $_SESSION['logged_in'] = $value;
}

// Add a function to check the current session status
function debugSessionStatus() {
 //   error_log("Session status: " . print_r($_SESSION, true));
}
