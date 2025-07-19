<?php
require_once '../session_start.php';
require_once '../functions.php';

if (!is_logged_in() || is_admin()) {
    redirect('/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Recipes - ChefAI</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Your Saved Recipes</h1>
        <p>This feature is coming soon!</p>
    </div>
</body>
</html>
