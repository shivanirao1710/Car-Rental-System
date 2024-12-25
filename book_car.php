<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['book'])) {
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $total_amount = $_POST['total_amount'];

    $query = "INSERT INTO bookings (user_id, car_id, start_date, end_date, total_amount, status) 
              VALUES ('$user_id', '$car_id', '$start_date', '$end_date', '$total_amount', 'Pending')";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Booking successful!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Booking failed. Try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Car</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Book a Car</h1>
    </header>
    <div class="container">
        <form action="" method="POST">
            <select name="car_id" required>
                <option value="">Select Car</option>
                <?php
                $query = "SELECT * FROM cars WHERE status = 'Available'";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']} ({$row['model']}) - {$row['rent_per_day']}/day</option>";
                }
                ?>
            </select>
            <input type="date" name="start_date" required>
            <input type="date" name="end_date" required>
            <input type="number" name="total_amount" placeholder="Total Amount" required>
            <button type="submit" name="book">Book Car</button>
        </form>
    </div>
</body>
</html>
