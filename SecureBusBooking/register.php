<?php
if (isset($_POST['submit'])) {
    // Sanitize user inputs to prevent SQL injection
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password using bcrypt
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);

    // Replace these with your actual database credentials
    $db_host = 'localhost';
    $db_user = 'root'; // Default XAMPP MySQL username
    $db_password = ''; // Default XAMPP MySQL password is empty
    $db_name = 'bus_booking_system';

    // Database connection
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Check the connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Prepared statement to prevent SQL injection
    $query = "INSERT INTO users (username, password, email, mobile, city) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Check if the prepared statement is successful
    if ($stmt) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("sssss", $username, $password, $email, $mobile, $city);

        // Execute the statement
        $result = $stmt->execute();

        // Check the execution result
        if ($result) {
            echo "User registered successfully!";
            
            // Redirect to the home page
            header("Location: home.php"); // Replace "home.php" with the actual URL of your home page
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
