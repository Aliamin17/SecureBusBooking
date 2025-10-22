<?php
// key_management.php

// Function to generate a new encryption key
function generateEncryptionKey($keyLength = 32) {
    return bin2hex(random_bytes($keyLength));
}

// Function to save the encryption key to a file
function saveEncryptionKeyToFile($key, $filePath) {
    if (file_put_contents($filePath, $key) !== false) {
        return true;
    }
    return false;
}

// Function to load the encryption key from a file
function loadEncryptionKeyFromFile($filePath) {
    if (file_exists($filePath)) {
        return file_get_contents($filePath);
    }
    return false;
}
?>
