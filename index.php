<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System</title>
    
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to Car Rental System</h1>
        <a href="login.php">Login</a> | <a href="register.php">Register</a>
    </header>
    <div class="container">
        <h2>Available Cars</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Car Name</th>
                    <th>Model</th>
                    <th>Rent/Day</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM cars";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['rent_per_day']}</td>
                        <td>{$row['status']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <footer>&copy; 2024 Car Rental System</footer>
</body>
</html>

