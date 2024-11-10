<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = isset($_POST['entername']) ? trim($_POST['entername']) : '';
    $username = isset($_POST['enterusername']) ? trim($_POST['enterusername']) : '';
    $password = isset($_POST['enterpassword']) ? trim($_POST['enterpassword']) : '';

    // Check if the fields are not empty
    if (!empty($name) && !empty($username) && !empty($password)) {
        // Open the CSV file in append mode
        $csvFile = fopen('users.csv', 'a');
        if ($csvFile !== false) {
            // Write the data to CSV (name, username, plain password)
            fputcsv($csvFile, [$name, $username, $password]);
            fclose($csvFile);

            // Redirect to a success page
            header('Location: signedup.html');
            exit();
        } else {
            $errorMessage = 'Error: Unable to save the data. Please try again later.';
        }
    } else {
        $errorMessage = 'Please fill in all fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup2.css" />
    <link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet" />
</head>

<body>
    <nav>
        <div id="logo-container">
            <a href="index.html"><img src="images/logo.png" alt="logo" id="logo"></a>
            <a href="index.html" id="site-name">Hidden Havens</a>
        </div>
    </nav>
    <div class="signup-box">
        <form action="" method="post">
            <p id="boxtitle">SIGN UP</p>
            <div class="form-fields">
                <div class="form-group">
                    <p class="entertitle">Name</p>
                    <input type="text" name="entername" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <p class="entertitle">Username</p>
                    <input type="text" name="enterusername" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <p class="entertitle">Password</p>
                    <input type="password" name="enterpassword" placeholder="Enter your password" required>
                </div>
            </div>
            <input type="submit" value="Create Account" id="create-acc-button">
            <a href="login.html">
                <p id="alreadyhave">Already have an account?</p>
            </a>

            <!-- Display error message if any -->
            <?php if (isset($errorMessage)): ?>
                <p style="color: red; text-align: center;"><?php echo htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>

        </form>
    </div>
</body>

</html>
