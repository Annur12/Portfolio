<?php

session_start();

include_once '../connection/connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL injection prevention: sanitize user inputs
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query to fetch user details from database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Authentication successful, set session variables
        $_SESSION['username'] = $username;

        // Redirect to a protected page
        header("Location: dashboard.php");
        exit;
    } else {
        // Authentication failed, redirect back to login page with error message
        header("Location: login_form.html?error=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/login.css">
    <title>Login</title>
</head>
<body>

    <header>
       <i class="bi bi-alexa"></i>
    </header>

    <div class="main-container">
        <div class="content-wrapper">
            <div class="title-wrapper">
                <h1>Welcome back</h1>
            </div>

            <div class="login-container">
                <form method="POST" action="#">
                    
                    <div class="input-wrapper">
                    <input class="input" type="text" name="username" placeholder="Username">
                    </div>
                    
                    <div class="input-wrapper">
                        <input class="input" type="password" name="password" placeholder="Password">
                    </div>
                    <button class="button">Login</button>
                    <p class="other-page">Don't have an account? <a href="" class="link">Sign Up</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>