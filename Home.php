<?php
// Start session and include the navigation bar
session_start();
include 'navbar.php';

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'project1');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bikes from the correct table
$sql = "SELECT * FROM carupload ORDER BY id DESC";
$result = $conn->query($sql);

// Close the database connection at the end
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike Bazaar</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <!-- Hero Section -->
    <div class="hero">
        <div>
            <h1>SECONDHAND BIKE SELLING SERVICE</h1>
            <p>"Certified Secondhand Bikes – Quality You Can Trust!"</p>
        </div>
    </div>

    <!-- Featured Bikes Section -->
    <!-- Featured Bikes Section -->
<div class="featured-bikes">
    <h2>Find Your Perfect Secondhand Bike</h2>
    <p>Reliable bikes at affordable prices</p>
    <div class="bike-list">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($bike = $result->fetch_assoc()): ?>
                <div class="bike-car">
                    <a href="carbooking.php?
                        car_name=<?php echo urlencode($bike['bike_name']); ?>&
                        price=<?php echo urlencode($bike['price']); ?>&
                        model=<?php echo urlencode($bike['model']); ?>&
                        kilometer=<?php echo urlencode($bike['kilometer']); ?>&
                        owner=<?php echo urlencode($bike['owner']); ?>&
                        description=<?php echo urlencode($bike['description']); ?>">
                        <img src="http://localhost/car/car/<?php echo htmlspecialchars($bike['image']); ?>" 
                             alt="Bike Image" style="max-width: 200px;">
                        <h3><?php echo htmlspecialchars($bike['bike_name']); ?></h3>
                        <p>Price: ₹<?php echo htmlspecialchars($bike['price']); ?></p>
                        <p>Model: <?php echo htmlspecialchars($bike['model']); ?></p>
                        <p>Kilometer: <?php echo htmlspecialchars($bike['kilometer']); ?> km</p>
                        <p>Owner: <?php echo htmlspecialchars($bike['owner']); ?></p>
                        <p><?php echo htmlspecialchars($bike['description']); ?></p>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No bikes available at the moment.</p>
        <?php endif; ?>
    </div>
</div>


</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
