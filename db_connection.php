<?php
// Database connection details
// These credentials are the standard defaults for a MySQL database in XAMPP.
$db_host = 'localhost';
$db_name = 'Chefai_DB';
$db_user = 'root';
$db_pass = ''; // In XAMPP, the 'root' user typically has no password.

try{
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>