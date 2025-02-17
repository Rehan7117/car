<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(244, 244, 244);
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            max-width: 1400px;
            margin: 50px auto;
            padding: 20px;
            background-color: blue;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .dashboard-header h1 {
            font-size: 24px;
            color: white;
        }
        .dashboard-header a {
            text-decoration: none;
            color: ;
            background-color:rgb(179, 255, 0);
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .dashboard-header a:hover {
            background-color:rgb(179, 42, 0);
        }
        .dashboard-content {
            font-size: 18px;
            color: #555;
        }
        ul {
            padding: 0;
            list-style-type: none;
        }
        li {
            margin: 10px 0;
        }
        li a {
            color:rgba(245, 249, 253, 0.96);
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }
        li a:hover {
            color:rgb(247, 243, 239);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
            <a href="admin_logout.php">Logout</a> <!-- Uncommented logout link -->
        </div>
        <div class="dashboard-content">
            <ul>
                <li><a href="user_details.php">View Users</a></li>
                <li><a href="carupload.php">Upload car</a></li> <!-- Fixed the link extension to .php -->
                <li><a href="carbookings.php"> car bookings</a></li> <!-- Fixed the link extension to .php -->
            </ul>
        </div>
    </div>
</body>
</html>
