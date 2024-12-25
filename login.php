<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email']; // Get email from the form
    $password = $_POST['password']; // Get password from the form

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);  // "s" stands for string
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Directly compare the entered password with the stored password
        if ($password === $row['password']) {  // Check if plain text password matches
            // Store user details in session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];  // Add the role to session (user/admin)

            // Redirect user based on role
            if ($_SESSION['role'] === 'admin') {
                header('Location: admin_index.php'); // Admin dashboard
            } else {
                header('Location: dashboard.php'); // User dashboard
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>User Login</h1>
    </header>
    <div class="container">
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
