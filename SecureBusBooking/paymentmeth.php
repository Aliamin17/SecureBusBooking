<?php
session_start();

include 'key_management.php'; // Include key management functions

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Encryption key and method
$keyFilePath = 'C:\xampp\htdocs\main\encryption_key.txt'; // Store the key in a file
$method = 'aes-256-cbc';

// Load the encryption key or generate a new one if not exists
$key = loadEncryptionKeyFromFile($keyFilePath);

if (!$key) {
    // Generate a new key if it doesn't exist
    $key = generateEncryptionKey();
    saveEncryptionKeyToFile($key, $keyFilePath);
}
// Encryption function
function encrypt($data, $key, $method) {
    $iv = random_bytes(16); // Generate a new 16-byte IV for each encryption
    $paddedIV = str_pad($iv, 16, "\0"); // Pad the IV to 16 bytes if needed
    $encrypted = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $paddedIV);
    return base64_encode($iv . $encrypted);
}

// Decryption function
function decrypt($data, $key, $method) {
    $data = base64_decode($data);
    $iv = substr($data, 0, 16); // Extract the IV from the ciphertext
    $paddedIV = str_pad($iv, 16, "\0"); // Pad the IV to 16 bytes if needed
    $data = substr($data, 16); // The rest is the encrypted data
    return openssl_decrypt($data, $method, $key, OPENSSL_RAW_DATA, $paddedIV);
}
// Database connection
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
    die("User ID not set in the session");
}

// Handle addition of a new payment method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_payment'])) {
    $user_id = $_SESSION['user_id'];
    $card_number = $_POST['card_number'];
    $expiration_date = $_POST['expiration_date'];
    $cvv = $_POST['cvv'];

    // Encrypt card number, expiration date, and CVV
    $encrypted_card_number = encrypt($card_number, $key, $method);
    $encrypted_expiration_date = encrypt($expiration_date, $key, $method);
    $encrypted_cvv = encrypt($cvv, $key, $method);

    // Use prepared statement to avoid SQL injection
    $sql_insert = "INSERT INTO payment_methods (user_id, card_number, expiration_date, cvv) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("isss", $user_id, $encrypted_card_number, $encrypted_expiration_date, $encrypted_cvv);
    
    if ($stmt->execute()) {
        // Redirect to avoid form re-submission on refresh
        header("Location: paymentmeth.php?added=true");
        exit();
    } else {
        echo "Error adding payment method: " . $stmt->error;
    }

    $stmt->close();
}

// Check if a new payment method was successfully added
$payment_added = isset($_GET['added']);

// Retrieve the user's payment methods
$user_id = $_SESSION['user_id'];

$sql_select = "SELECT card_number, expiration_date, cvv FROM payment_methods WHERE user_id = ?";
$stmt = $conn->prepare($sql_select);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$payment_methods = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Decrypt each field before adding to the array
        $row['card_number'] = decrypt($row['card_number'], $key, $method);
        $row['expiration_date'] = decrypt($row['expiration_date'], $key, $method);
        $row['cvv'] = decrypt($row['cvv'], $key, $method);
        $payment_methods[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
    <link rel="stylesheet" href="web.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>
<?php include 'header.php'; ?>

<section id="payment-methods">
    <h2>Payment Methods</h2>
    <?php if ($payment_added): ?>
        <p>Payment method added successfully!</p>
    <?php endif; ?>
    <ul>
        <?php
        if (!empty($payment_methods)) {
            foreach ($payment_methods as $payment_method) {
                // Display the decrypted information
                echo '<li>' . htmlspecialchars($payment_method['card_number']) . ' - ' . htmlspecialchars($payment_method['expiration_date']) . ' - ' . htmlspecialchars($payment_method['cvv']) . '</li>';
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
