<?php
session_start();

if (\$_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read CSV file for usernames and passwords
    \$csvFile = fopen('users.csv', 'r');
    \$isValidUser = false;

    // Get user input
    \$inputUsername = isset(\$_POST['username']) ? trim(\$_POST['username']) : '';
    \$inputPassword = isset(\$_POST['password']) ? trim(\$_POST['password']) : '';

    // Check credentials against CSV
    while ((\$data = fgetcsv(\$csvFile, 1000, ',')) !== FALSE) {
        \$username = \$data[0];
        \$password = \$data[1];

        if (\$inputUsername === \$username && \$inputPassword === \$password) {
            \$isValidUser = true;
            // Set session to indicate logged-in user
            \$_SESSION['loggedin'] = true;
            \$_SESSION['username'] = \$username;
            break;
        }
    }
    fclose(\$csvFile);

    // Redirect or display error message
    if (\$isValidUser) {
        header('Location: locations.php');
        exit();
    } else {
        \$errorMessage = 'Invalid username or password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css" />
    <link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet" />
    <title>Log in</title>
</head>
<body>
    <nav>
        <div id="logo-container">
            <a href="index.html"><img src="images/logo.png" alt="logo" id="logo"></a>
            <a href="index.html" id="site-name">Hidden Havens</a>
        </div>
    </nav>

    <form action="" method="post">
        <div id="top-container">
            <p id="log-in">LOG IN</p>
            <div id="goog-container">
                <img src="images/google.png" alt="googlelogo" id="googlelogo">
                <p id="sign-in-google">&nbsp;&nbsp;Sign in with Google</p>
            </div>
        </div>

        <div id="form-fields">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">Sign in</button>
        </div>

        <?php if (isset(\$errorMessage)): ?>
            <p style="color: red; text-align: center;"> <?= htmlspecialchars(\$errorMessage) ?> </p>
        <?php endif; ?>

        <div id="questions">
            <p>Forgot your password?</p>
            <p>Don't have an account? <a href="signup.html" id="link">Sign up?</a></p>
        </div>
    </form>
</body>
</html>
