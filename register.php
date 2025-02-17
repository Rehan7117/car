<?php include 'navbar.php'; ?>

<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project1'); // Change 'user_db' to 'project1'

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming the form inputs are available in $_POST
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    
    // Ensure the password and confirm password match
    if ($_POST['password'] === $_POST['confirm_password']) {
        // Hash password
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Insert user data into the database
        $sql = "INSERT INTO users (username, email, first_name, last_name, phone, password) 
                VALUES ('$username', '$email', '$first_name', '$last_name', '$phone', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            // Redirect to login page
            header("Location: login.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Password and Confirm Password do not match.";
    }
}

$conn->close();
?>

<!-- HTML Form for Registration -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="register.css"> <!-- Link to your external CSS file -->

</head>
<body>
    <h2>Register</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
