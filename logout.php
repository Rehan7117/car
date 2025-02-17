<?php
session_start();
session_unset();
session_destroy();

// Redirect to home page
header("Location: home.php");
exit();
?>
