<?php
$host = 'localhost'; // Change this to your MySQL host if it's different
$dbname = 'collageapp'; // Change this to your database name
$username = 'root'; // Change this to your MySQL username
$password = ''; // Change this to your MySQL password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set PDO to throw exceptions for errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Additional configuration options if needed
    // $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
    die(); // Terminate script execution
}

// Connection successful, you can use $pdo for database operations

?>
