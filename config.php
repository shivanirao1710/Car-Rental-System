<?php
// Database configuration
$host = "localhost"; // Host name
$username = "root"; // MySQL username (default is 'root' for XAMPP)
$password = ""; // MySQL password (default is empty for XAMPP)
$database = "car_rental"; // Database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
