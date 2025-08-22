<?php
session_start();
// ...existing code...
if (!is_logged_in() || is_admin()) {
    // If not logged in, redirect them to the login page.
    redirect('../login.php'); // Use relative path to ChefAI root
}
// ...existing code...

/**
 * Checks if a user is logged in by verifying the session.
 * @return bool True if a user is logged in, false otherwise.
 */
function is_logged_in() {
    // Return true if the user_id exists in the session, false otherwise.
    return isset($_SESSION['user_id']);
}

/**
 * Checks if the logged-in user is an admin.
 * For this example, we assume admin status is not set, so it always returns false.
 * In a real application, you would check a database field here.
 * @return bool True if the user is an admin, false otherwise.
 */
function is_admin() {
    // This is a placeholder. You would implement a check against the database
    // or session to determine if the user has an admin role.
    return false;
}

/**
 * Redirects the user to a specified URL.
 * @param string $url The URL to redirect to.
 */
function redirect($url) {
    // Send the HTTP redirect header.
    header("Location: " . $url);
    // Terminate the script to ensure the redirect happens immediately.
    exit();
}

// Now we use the functions we just defined.
// Check if the user is NOT logged in.
if (!is_logged_in() || is_admin()) {
    // If not logged in, redirect them to the login page.
    redirect('../login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ChefAI - Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4CAF50;
      --secondary: #2E8B57;
      --accent: #8CFF98;
      --dark: #0d1c10;
      --white: #fff;
    }

    /* Reset + background */
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      color: var(--white);
      overflow-x: hidden;
    }

    /* Animated gradient waves background */
    .wave {
      position: fixed;
      width: 200%;
      height: 200%;
      top: -50%;
      left: -50%;
      background: radial-gradient(circle at 30% 30%, rgba(76,175,80,0.3), transparent 60%),
                  radial-gradient(circle at 70% 70%, rgba(46,139,87,0.3), transparent 60%);
      animation: rotate 20s infinite linear;
      z-index: -2;
    }
    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* Floating food icons */
    .floating-icons {
      position: fixed;
      inset: 0;
      z-index: -1;
      pointer-events: none;
    }
    .floating-icons span {
      position: absolute;
      font-size: 2.5rem;
      opacity: 0.12;
      animation: float 12s infinite ease-in-out;
    }
    .floating-icons span:nth-child(1){top:20%;left:15%;animation-duration:18s;}
    .floating-icons span:nth-child(2){top:65%;left:80%;animation-duration:22s;}
    .floating-icons span:nth-child(3){top:75%;left:25%;animation-duration:20s;}
    .floating-icons span:nth-child(4){top:40%;left:60%;animation-duration:16s;}
    .floating-icons span:nth-child(5){top:85%;left:10%;animation-duration:24s;}
    @keyframes float {
      0% { transform: translateY(0) rotate(0); }
      50% { transform: translateY(-25px) rotate(20deg); }
      100% { transform: translateY(0) rotate(0); }
    }

    /* Navbar */
    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      padding: 1rem 2.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(0,0,0,0.3);
      backdrop-filter: blur(12px);
      z-index: 1000;
    }
    .navbar-logo {
      font-size: 2rem;
      font-weight: 700;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-decoration: none;
    }
    .nav-links {
      list-style: none;
      display: flex;
      gap: 1.5rem;
      margin: 0;
      padding: 0;
    }
    .nav-link {
      text-decoration: none;
      color: var(--white);
      font-weight: 500;
      position: relative;
      transition: color 0.3s;
    }
    .nav-link:hover {
      color: var(--accent);
    }

    /* Hero section */
    .hero {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 3rem 1rem;
      margin-top: 7rem;
      animation: fadeUp 1s ease;
    }
    .hero h1 {
      font-family: "Playfair Display", serif;
      font-size: 3rem;
      color: var(--accent);
      text-shadow: 0 0 15px rgba(140,255,152,0.6);
      margin-bottom: 1rem;
    }
    .hero p {
      font-size: 1.2rem;
      max-width: 600px;
      opacity: 0.85;
    }
    @keyframes fadeUp {
      from {opacity:0; transform: translateY(40px);}
      to {opacity:1; transform: translateY(0);}
    }

    /* Buttons */
    .nav-buttons {
      margin-top: 2.5rem;
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      justify-content: center;
    }
    .btn {
      text-decoration: none;
      padding: 14px 28px;
      border-radius: 50px;
      font-weight: 600;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      color: var(--white);
      box-shadow: 0 0 15px rgba(76,175,80,0.6);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 0 25px rgba(140,255,152,0.9);
    }

    /* Footer */
    footer {
      background: rgba(0,0,0,0.4);
      text-align: center;
      padding: 1rem;
      font-size: 0.9rem;
      color: #ddd;
    }
    footer a {
      color: var(--accent);
      margin: 0 10px;
      text-decoration: none;
    }

    @media(max-width:768px){
      .hero h1{font-size:2.2rem;}
      .nav-buttons{flex-direction:column;}
    }
  </style>
</head>
<body>

  <div class="wave"></div>
  <div class="floating-icons">
    <span>🥗</span>
    <span>🍲</span>
    <span>🍴</span>
    <span>🍕</span>
    <span>🥘</span>
  </div>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="/ChefAI/User/user_homepage.php" class="navbar-logo">ChefAI</a>
    <ul class="nav-links">
      <li><a href="/ChefAI/User/user_homepage.php" class="nav-link">Home</a></li>
      <li><a href="/ChefAI/User/generate_recipe.php" class="nav-link">Generate Recipe</a></li>
      <li><a href="/ChefAI/User/profile.php" class="nav-link">Profile</a></li>
    </ul>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Welcome,! <?php echo $_SESSION['username']; ?>!</h1>
    <p>Your personal AI chef 🍴 — discover, generate, and save delicious recipes made just for you.</p>
    <div class="nav-buttons">
      <a href="generate_recipe.php" class="btn">✨ Generate Recipe</a>
      <a href="saved_recipes.php" class="btn">💾 Saved Recipes</a>
      <a href="profile.php" class="btn">👤 Profile</a>
      <a href="../logout.php" class="btn">🚪 Logout</a>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>© 2025 ChefAI | Crafted with 🍳 + ❤️</p>
    <p><a href="#">Twitter</a> | <a href="#">Instagram</a> | <a href="#">Contact</a></p>
  </footer>

</body>
</html>
