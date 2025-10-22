<?php
// Start the session
session_start();

// Check if the user is logged in
$loggedIn = isset($_SESSION['username']);

// Include the header


// Your database connection logic goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_booking_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    // You might want to redirect to the login page or handle this case appropriately
    die("User ID not set in the session");
}

// Retrieve user data from the database
$user_id = $_SESSION['user_id'];

// Use prepared statement to avoid SQL injection
$sql_select_user = "SELECT username, email, mobile, city FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_select_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();

$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();
} else {
    // Handle the case where user data is not found
    die("User data not found");
}

$stmt_user->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>
    <link rel="stylesheet" href="web.css">
    <link rel="stylesheet" href="home.css">
    <!-- Add any additional CSS files as needed -->
</head>
<body>
<?php include 'header.php'; ?>
    <section id="about-me">
        <h2>About Me</h2>
        <?php
        if ($loggedIn) {
            // Display user-specific content or user details
            echo "<p>Welcome, " . $user_data['username'] . "!</p>";
            echo "<p>Email: " . $user_data['email'] . "</p>";
            echo "<p>Mobile: " . $user_data['mobile'] . "</p>";
            echo "<p>City: " . $user_data['city'] . "</p>";
            // Add more user-specific content as needed
        } else {
            echo "<p>This is a general about me section. You can customize it based on your requirements.</p>";
        }
        ?>
    </section>

    <!-- Add any additional sections or content as needed -->

    <footer>
        <p>&copy; 2023 Bus Booking System</p>
    </footer>

</body>
</html>
