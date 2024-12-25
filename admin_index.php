<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'config.php';

// Fetch all cars from the database
$query_cars = "SELECT * FROM cars";
$result_cars = $conn->query($query_cars);

// Fetch all users from the database
$query_users = "SELECT * FROM users";
$result_users = $conn->query($query_users);

// Fetch booking details along with user and car information
$query_bookings = "
    SELECT bookings.id AS booking_id, 
           bookings.start_date, 
           bookings.end_date, 
           bookings.total_amount, 
           bookings.status AS booking_status, 
           users.name AS user_name, 
           users.email AS user_email, 
           cars.name AS car_name, 
           cars.model AS car_model
    FROM bookings
    INNER JOIN users ON bookings.user_id = users.id
    INNER JOIN cars ON bookings.car_id = cars.id
";
$result_bookings = $conn->query($query_bookings);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to the Admin Dashboard</h1>
        <a href="logout.php">Logout</a>
    </header>

    <div class="container">
        <h2>Cars List</h2>
        <a href="add_car.php" class="add-car-btn"><button>Add New Car</button></a>

        <table class="table">
            <thead>
                <tr>
                    <th>Car Name</th>
                    <th>Model</th>
                    <th>Rent per Day</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_cars->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td>$<?php echo $row['rent_per_day']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href="edit_car.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                            <a href="delete_car.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>User List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_users->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                            <a href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Booking Details</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Car Name</th>
                    <th>Model</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_bookings->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['user_email']; ?></td>
                        <td><?php echo $row['car_name']; ?></td>
                        <td><?php echo $row['car_model']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td><?php echo $row['end_date']; ?></td>
                        <td>$<?php echo $row['total_amount']; ?></td>
                        <td><?php echo $row['booking_status']; ?></td>
                        <td>
                            <a href="edit_booking.php?id=<?php echo $row['booking_id']; ?>">Edit</a> | 
                            <a href="delete_booking.php?id=<?php echo $row['booking_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
