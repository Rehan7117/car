<?php
// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the navbar
include 'navbar.php';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project1'); // Change 'project1' to your database name

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize the input to avoid SQL injection
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Check if the username/email exists in the database
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user data in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];

            // Redirect to the home page
            header("Location: home.php");
            exit(); // Ensure no further code is executed
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with that username/email.";
    }
}
?>

<!-- HTML Form for Login -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="register.css"> <!-- Link to your external CSS file -->

</head>
<body>
    <h2>Login</h2>

    <!-- Error Message -->
    <?php if (isset($error_message)): ?>
        <p style='color: red;'><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST">
        <label for="username">Username or Email:</label>
        <input type="text" id="username" placeholder="username"  name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="password" name="password" required><br>

        <button type="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Register here</a></p>

    </form>

</body>
</html>
