<?php
/*
* Database Configuration
*
* For this project, database credentials are set directly in this file.
* In a production environment, it is highly recommended to use environment variables
* to keep sensitive data like passwords out of the source code.
*/

// Database credentials
$db_host = 'localhost';
$db_name = 'ChefAI_DB';
$db_user = 'root';
$db_pass = ''; // Default XAMPP password is empty, change if you have set one.

// Create a PDO instance
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // If connection fails, stop the script and show an error message.
    // For a live site, you would log this error and show a generic message.
    die("Database connection failed: " . $e->getMessage());
}