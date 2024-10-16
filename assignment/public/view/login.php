<?php
session_start();
$host = 'localhost'; // or your database host
$dbname = 'db'; // your database name
$username = 'root'; // your database username
$password = ''; // your database password

// Initialize an array to hold debug messages
$debugMessages = [];

function debug_log($message) {
    global $debugMessages;
    $debugMessages[] = htmlspecialchars($message);
}

// Log the start of the script
debug_log("Script started");

// Database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    debug_log("Database connection successful");
} catch(PDOException $e) {
    debug_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    debug_log("Form submitted");
    // Check if username and password are set in $_POST
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        debug_log("Submitted username: " . $username);

        // Query the database for the user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            debug_log("Credentials match");
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id']; // Make sure to set user_id
            
            debug_log("Session set. Redirecting to dashboard.php");
            debug_log("Session data: " . print_r($_SESSION, true));
            
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password";
            debug_log("Login failed for user: " . $username);
        }
    } else {
        $error = "Username and password are required";
        debug_log("Username or password not set in POST data");
    }
}

// Log the end of the script
debug_log("End of script. Session data: " . print_r($_SESSION, true));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .login-form { width: 300px; margin: 0 auto; padding: 20px; }
        .login-form input { width: 100%; padding: 10px; margin: 10px 0; }
        .login-form input[type="submit"] { background-color: #4CAF50; color: white; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>" . htmlspecialchars($error) . "</p>"; } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
    </div>
    <script>
        // Log debug messages to the console
        const debugMessages = <?php echo json_encode($debugMessages); ?>;
        debugMessages.forEach(message => console.log("[DEBUG] " + message));
    </script>
</body>
</html>
