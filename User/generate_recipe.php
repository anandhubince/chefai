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
    <title>Generate Recipe - ChefAI</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Generate a New Recipe</h1>
        <form id="recipe-form">
            <div class="form-group">
                <label for="ingredients">Enter your ingredients (comma-separated)</label>
                <textarea id="ingredients" name="ingredients" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn">Generate</button>
        </form>
        <div id="recipe-result"></div>
    </div>
    <script src="../script.js"></script>
</body>
</html>
