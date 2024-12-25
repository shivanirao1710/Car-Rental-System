<?php
session_start();

// Check if the user is logged in and is a regular user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

include 'config.php';

// Fetch all cars from the database
$query = "SELECT * FROM cars";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to Car Rental Dashboard</h1>
        <a href="logout.php">Logout</a>
    </header>

   
    <div class="container">
        <h2>Available Cars</h2>
        <!-- Button to redirect to Book Car Page -->
        <a href="book_car.php" class="add-car-btn"><button>Book Car</button></a>
        
        <!-- Button to redirect to View Bookings page -->
        <a href="bookings.php" class="view-bookings-btn"><button>View Bookings</button></a>
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
                <?php while ($row = $result->fetch_assoc()) { ?>
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
    </div>
</body>
</html>
