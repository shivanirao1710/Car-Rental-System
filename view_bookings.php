<?php
include 'config.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>All Bookings</h1>
    </header>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Car</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT u.name as user_name, c.name as car_name, b.start_date, b.end_date, b.status 
                          FROM bookings b 
                          JOIN users u ON b.user_id = u.id 
                          JOIN cars c ON b.car_id = c.id";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['user_name']}</td>
                            <td>{$row['car_name']}</td>
                            <td>{$row['start_date']}</td>
                            <td>{$row['end_date']}</td>
                            <td>{$row['status']}</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
