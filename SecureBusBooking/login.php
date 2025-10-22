<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_booking_system";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            // Successful login
            session_start(); // Start the session

            // Retrieve user_id from the database
            $user_id = $user["id"];

            // Store data in the session
            $_SESSION['username'] = $username; // Store the username in the session
            $_SESSION['user_id'] = $user_id; // Store the user_id in the session

            // Redirect to the home page
            header("Location: home.php"); // Replace "home.php" with the actual URL of your home page
            exit();
        } else {
            // Failed login, implement your logic (display error message, redirect, etc.)
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
