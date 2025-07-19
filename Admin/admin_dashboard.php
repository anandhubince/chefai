<?php
require_once '../session_start.php';
require_once '../functions.php';

if (!is_logged_in() || !is_admin()) {
    redirect('/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ChefAI</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="user_management.php" class="btn">User Management</a>
            <a href="../logout.php" class="btn">Logout</a>
        </nav>
    </div>
</body>
</html>
