<?php
// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    /* Navbar container styles */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: blue;
        color: white;
        padding: 10px 20px;
        box-shadow: 0 2px 5px rgba(15, 204, 141, 0.93);
        font-family: Arial, sans-serif;
    }

    /* Navbar title styles */
    .navbar h1 {
        margin: 0;
        font-size: 1.5rem;
    }

    /* Navbar link container */
    .navbar div {
        display: flex;
        align-items: center;
    }

    /* Navbar links */
    .navbar a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Hover effect for links */
    .navbar a:hover {
        background-color:rgb(201, 233, 17);
        color: #f0f0f0;
    }

    /* Welcome text styles */
    .navbar span {
        margin-right: 10px;
        font-size: 0.9rem;
        font-weight: bold;
    }

    /* Responsive styles */
    @media (max-width: 600px) {
        .navbar {
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar div {
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar a {
            margin: 5px 0;
        }
    }
</style>

<div class="navbar">
    <h1>Bike Bazaar</h1>
    <div>
        <a href="home.php">Home</a>
        
        <!-- Check if the user is logged in, then show the welcome message and logout link -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php">Logout</a>
            <!-- "Book a Bike" link is only shown if the user is logged in -->
            <a href="carbooking.php">Book a Bike</a>
        <?php else: ?>
            <!-- If the user is not logged in, show login link -->
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</div>
