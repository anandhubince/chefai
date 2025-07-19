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
    <title>User Homepage - ChefAI</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <nav>
            <a href="generate_recipe.php" class="btn">Generate Recipe</a>
            <a href="saved_recipes.php" class="btn">Saved Recipes</a>
            <a href="profile.php" class="btn">Profile</a>
            <a href="../logout.php" class="btn">Logout</a>
        </nav>
    </div>
</body>
</html>
