<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project1'); // Update your database name if necessary

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all booking data
$sql = "SELECT 
            bike_bookings.id,
            bike_bookings.bike_name,
            users.username,
            users.email,
            users.phone,
            bike_bookings.price,
            bike_bookings.model,
            bike_bookings.kilometer,
            bike_bookings.owner,
            bike_bookings.description,
            bike_bookings.booking_date
        FROM bike_bookings
        JOIN users ON bike_bookings.user_id = users.id"; // Join with the users table to get user details

// Execute the query and check for errors
$result = $conn->query($sql);

// Check if query execution was successful
if (!$result) {
    die("Error executing query: " . $conn->error); // Output the error if the query fails
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .dashboard-container {
            max-width: 1400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard-header h1 {
            color: #333;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:nth-child(odd) {
            background-color: #f4f4f4;
        }
        .logout-btn {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
        </div>
        <div class="dashboard-content">
            <h2>All Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Bike Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Price</th>
                        <th>Model</th>
                        <th>Kilometer</th>
                        <th>Owner</th>
                        <th>Description</th>
                        <th>Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are rows returned by the query
                    if ($result->num_rows > 0) {
                        // Loop through the results and display the data
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['id']) . "</td>
                                    <td>" . htmlspecialchars($row['bike_name']) . "</td>
                                    <td>" . htmlspecialchars($row['username']) . "</td>
                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                    <td>" . htmlspecialchars($row['phone']) . "</td>
                                    <td>₹ " . number_format($row['price'], 2) . "</td>
                                    <td>" . htmlspecialchars($row['model']) . "</td>
                                    <td>" . htmlspecialchars($row['kilometer']) . " km</td>
                                    <td>" . htmlspecialchars($row['owner']) . "</td>
                                    <td>" . nl2br(htmlspecialchars($row['description'])) . "</td>
                                    <td>" . htmlspecialchars($row['booking_date']) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>No bookings found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
