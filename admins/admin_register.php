<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project1');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_name = $conn->real_escape_string($_POST['admin_name']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins (admin_name, password) VALUES ('$admin_name', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Admin registered successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" type="text/css" href="adminregister.css"> <!-- Link to your external CSS file -->

</head>
<body>
    <form method="POST">
        <label for="admin_name">Admin Name:</label>
        <input type="text" id="admin_name" name="admin_name" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
