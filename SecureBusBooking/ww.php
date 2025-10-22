<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}

// Your database connection logic goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_booking_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the user's payment methods
$user_id = $_SESSION['user_id']; // Assuming you have stored user_id in the session during login
$sql = "SELECT * FROM payment_methods WHERE user_id = $user_id";
$result = $conn->query($sql);

$payment_methods = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $payment_methods[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
    <link rel="stylesheet" href="web.css">
    <link rel="stylesheet" href="home.css"> <!-- Link to your CSS file -->
</head>
<body>

<header>
    <!-- Your header code remains the same -->
</header>

<section id="payment-methods">
    <h2>Payment Methods</h2>
    <ul>
        <?php
        if (!empty($payment_methods)) {
            foreach ($payment_methods as $payment_method) {
                echo '<li>' . $payment_method['card_number'] . ' - ' . $payment_method['expiration_date'] . '</li>';
            }
        } else {
            echo '<li>No payment methods available</li>';
        }
        ?>
    </ul>
</section>

<section id="add-payment">
    <h2>Add Payment Method</h2>
    <form action="paymentmeth.php" method="post">
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required>

        <label for="expiration_date">Expiration Date:</label>
        <input type="text" id="expiration_date" name="expiration_date" required>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>

        <button type="submit" name="add_payment">Add Payment Method</button>
    </form>
</section>


<footer>
      <p>&copy; 2023 Bus Booking System</p>
</footer>

</body>
</html>
