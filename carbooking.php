<?php
// Include navbar, which already starts the session
include 'navbar.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch car details from URL parameters
$car_name = isset($_GET['car_name']) ? $_GET['car_name'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$model = isset($_GET['model']) ? $_GET['model'] : '';
$kilometer = isset($_GET['kilometer']) ? $_GET['kilometer'] : '';
$owner = isset($_GET['owner']) ? $_GET['owner'] : '';
$description = isset($_GET['description']) ? $_GET['description'] : '';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project1');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_details = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username, email, phone FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user_details = $result->fetch_assoc();
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone']; // User can modify phone number

    // Insert booking details into the `carbookings` table
    $stmt = $conn->prepare("INSERT INTO carbookings 
        (user_id, car_name, username, email, phone, price, model, kilometer, owner, description) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("isssssssss", $user_id, $car_name, $user_details['username'], $user_details['email'], 
                      $phone, $price, $model, $kilometer, $owner, $description);
    
    if ($stmt->execute()) {
        $success_message = "Car booking successful!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .booking-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .booking-container h2 {
            color: #333;
        }
        .booking-container form {
            margin-top: 20px;
        }
        .booking-container label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .booking-container input, .booking-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .booking-container button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .booking-container button:hover {
            background-color: #0056b3;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <h2>Book a Car</h2>

        <?php if (isset($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Booking form -->
        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user_details['username'] ?? ''); ?>" readonly>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user_details['email'] ?? ''); ?>" readonly>

            <label for="phone">Phone Number</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user_details['phone'] ?? ''); ?>" required>

            <label for="car_name">Car Name</label>
            <input type="text" name="car_name" id="car_name" value="<?php echo htmlspecialchars($car_name); ?>" readonly>

            <label for="price">Price</label>
            <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($price); ?>" readonly>

            <label for="model">Model</label>
            <input type="text" name="model" id="model" value="<?php echo htmlspecialchars($model); ?>" readonly>

            <label for="kilometer">Kilometer</label>
            <input type="text" name="kilometer" id="kilometer" value="<?php echo htmlspecialchars($kilometer); ?>" readonly>

            <label for="owner">Owner</label>
            <input type="text" name="owner" id="owner" value="<?php echo htmlspecialchars($owner); ?>" readonly>

            <label for="description">Description</label>
            <textarea name="description" id="description" readonly><?php echo htmlspecialchars($description); ?></textarea>

            <button type="submit">Book Now</button>
        </form>
    </div>
</body>
</html>
