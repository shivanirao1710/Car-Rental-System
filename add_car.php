<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'config.php';

if (isset($_POST['add_car'])) {
    $name = $_POST['name'];
    $model = $_POST['model'];
    $rent_per_day = $_POST['rent_per_day'];

    // Prepare and bind statement for security (prevent SQL injection)
    $stmt = $conn->prepare("INSERT INTO cars (name, model, rent_per_day, status) VALUES (?, ?, ?, 'Available')");
    $stmt->bind_param("ssi", $name, $model, $rent_per_day);  // 'ssi' means string, string, integer

    // Execute and check if the insertion was successful
    if ($stmt->execute()) {
        echo "<script>alert('Car added successfully!'); window.location='admin_index.php';</script>";
    } else {
        echo "<script>alert('Failed to add car.');</script>";
    }
    $stmt->close();  // Close the prepared statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Add New Car</h1>
        <a href="admin_index.php">Back to Dashboard</a>
    </header>

    <div class="container">
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Car Name" required>
            <input type="text" name="model" placeholder="Car Model" required>
            <input type="number" name="rent_per_day" placeholder="Rent per Day" required>
            <button type="submit" name="add_car">Add Car</button>
        </form>
    </div>
</body>
</html>
