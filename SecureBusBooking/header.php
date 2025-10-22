<?php
// Check if a session is not already active before starting a new one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
$loggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Booking System</title>
    <link rel="stylesheet" href="web.css"> <!-- Include your CSS file -->
</head>
<body>

<header>
    <div class="title">Bus Booking System</div>
    <?php
    if ($loggedIn) {
        echo '<div class="dropdown">';
        echo '<button class="dropbtn">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">';
        echo '<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>';
        echo '</svg>';
        echo '</button>';
        echo '<div class="dropdown-content">';
        echo '<button onclick="location.href=\'#\'">My Trips</button>';
        echo '<button onclick="location.href=\'paymentmeth.php\'">Payment Methods</button>';
        echo '<button onclick="location.href=\'about.php\'">About Me</button>';
        echo '<button onclick="location.href=\'home.php\'">Home</button>';
        echo '<form method="post" action="home.php">'; // Modified line
        echo '<button type="submit" name="logout">Logout</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="login-button"><a href="login.html">Login</a></div>';
    }
    ?>
</header>

</body>
</html>
