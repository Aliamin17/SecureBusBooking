<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $loggedIn = true;
} else {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session data
    header("Location: login.html"); // Redirect to the login page after logout
    exit();
}

// Your database connection logic goes here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Booking</title>
    <link rel="stylesheet" href="web.css">
    <link rel="stylesheet" href="home.css"> <!-- Link to your CSS file -->

</head>
<body>
<?php include 'header.php'; ?>

    <?php
    if ($loggedIn) {
        // Display booking form for logged-in users
        ?>
        <section id="booking-form">
            <h2>Book Your Bus Ticket</h2>
            <form action="book.php" method="post">
                <label for="origin">Origin:</label>
                <select id="origin" name="origin" required>
                    <option value="Cairo">Cairo</option>
                    <option value="Alexandria">Alexandria</option>
                    <option value="Luxor">Luxor</option>
                    <option value="Aswan">Aswan</option>
                    <option value="Giza">Giza</option>
                    <option value="Sharm El Sheikh">Sharm El Sheikh</option>
                    <option value="Hurghada">Hurghada</option>
                    <option value="Dahab">Dahab</option>
                    <option value="Siwa">Siwa</option>
                    <option value="Marsa Alam">Marsa Alam</option>
                </select>

                <label for="destination">Destination:</label>
                <select id="destination" name="destination" required>
                    <option value="Cairo">Cairo</option>
                    <option value="Alexandria">Alexandria</option>
                    <option value="Luxor">Luxor</option>
                    <option value="Aswan">Aswan</option>
                    <option value="Giza">Giza</option>
                    <option value="Sharm El Sheikh">Sharm El Sheikh</option>
                    <option value="Hurghada">Hurghada</option>
                    <option value="Dahab">Dahab</option>
                    <option value="Siwa">Siwa</option>
                    <option value="Marsa Alam">Marsa Alam</option>
                </select>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <button type="submit">Search Buses</button>
            </form>
        </section>

        <section id="available-buses">
            <h2>Available Buses</h2>
            <!-- Display bus options dynamically here using JavaScript -->
        </section>
        <?php
    }
    ?>

    <footer>
        <p>&copy; 2023 Bus Booking System</p>
    </footer>

</body>
</html>
