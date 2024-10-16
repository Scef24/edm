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
        <form action="index.php?action=login" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
    </div>
    <script>
        // Log debug messages to the console
        const debugMessages = <?php echo json_encode($debugMessages ?? []); ?>;
        debugMessages.forEach(message => console.log("[DEBUG] " + message));
    </script>
</body>
</html>
