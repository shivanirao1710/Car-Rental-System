<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Your Bookings</h1>
    </header>
    <div class="container">
        <!-- Table to display bookings -->
        <table class="table">
            <thead>
                <tr>
                    <th>Car Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Use prepared statements to prevent SQL injection
                $query = "SELECT b.*, c.name as car_name FROM bookings b 
                          JOIN cars c ON b.car_id = c.id WHERE b.user_id = ?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("i", $user_id);  // "i" is for integer type
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Loop through each booking and display it
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['car_name']}</td>
                                    <td>{$row['start_date']}</td>
                                    <td>{$row['end_date']}</td>
                                    <td>{$row['total_amount']}</td>
                                    <td>{$row['status']}</td>
                                </tr>";
                        }
                    } else {
                        // Display message if no bookings are found
                        echo "<tr><td colspan='5'>No bookings found</td></tr>";
                    }

                    $stmt->close();
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
