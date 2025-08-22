<?php
    // PHP logic will be added back here later (session_start, etc.)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* Add to style.css or in a <style> block */
.hero-section {
    position: relative;
    min-height: 400px;
    background: url('images/pre-prepared-food-showcasing-ready-eat-delicious-meals-go.jpg') center center/cover no-repeat;
    color: #fff;
}

.hero-background-image {
    display: none; /* Hide the <img> if using background-image */
}

.hero-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.7); /* Darker overlay for better contrast */
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 100px 20px 40px 20px;
}

.hero-content h1,
.hero-content p {
    text-shadow: 0 2px 12px rgba(0,0,0,0.9); /* Stronger shadow for readability */
}
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChefAI - Your AI-Powered Culinary Assistant</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- External Stylesheet -->
    <link rel="stylesheet" href="style.css">

    <!-- Font Awesome for Icons (optional, but useful for social icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <!-- Header -->
    <header class="main-header">
        <a href="#" class="logo">ChefAI</a>
        <nav class="main-nav">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </nav>
    </header>

    <!-- 1. Hero Section -->
    <section class="section hero-section">
        <img src="images/pre-prepared-food-showcasing-ready-eat-delicious-meals-go.jpg" alt="ChefAI Background" class="hero-background-image">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Never Wonder What to Cook Again</h1>
            <p>Transform your leftover ingredients into delicious, AI-generated recipes in seconds. Your next favorite meal is just a click away.</p>
            <div class="button-container">
                <a href="register.php" class="btn btn-primary">Get Started for Free</a>
                <a href="#how-it-works" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- 2. How It Works Section -->
    <section id="how-it-works" class="section how-it-works">
        <h2 class="section-title">Effortless Meals in 3 Simple Steps</h2>
        <div class="steps-container">
            <div class="step">
                <div class="step-icon"><i class="fas fa-list-ul"></i></div>
                <h3>Enter Ingredients</h3>
                <p>Tell ChefAI what you have in your fridge. No ingredient is too random!</p>
            </div>
            <div class="step">
                <div class="step-icon"><i class="fas fa-brain"></i></div>
                <h3>Get Instant Recipes</h3>
                <p>Our AI instantly crafts unique, step-by-step recipes tailored to you.</p>
            </div>
            <div class="step">
                <div class="step-icon"><i class="fas fa-utensils"></i></div>
                <h3>Cook, Save & Enjoy</h3>
                <p>Follow the easy instructions and save your favorite creations to your personal cookbook.</p>
            </div>
        </div>
    </section>

    <!-- 3. Features Section -->
    <section class="section features">
        <h2 class="section-title">A Smarter Way to Cook</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-lightbulb"></i></div>
                <h3>Limitless Creativity</h3>
                <p>Break free from your cooking routine and discover exciting new flavor combinations you'll love.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-leaf"></i></div>
                <h3>Reduce Food Waste</h3>
                <p>Make the most of what you have. ChefAI helps you use up ingredients, saving you money and helping the planet.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-bookmark"></i></div>
                <h3>Personalized Cookbook</h3>
                <p>Save your favorite AI-generated recipes to build a personal collection that grows with your culinary journey.</p>
            </div>
        </div>
    </section>

    <!-- 4. Testimonials Section -->
    <section class="section testimonials">
        <h2 class="section-title">What Our Users Are Saying</h2>
        <div class="testimonial-quote">
            <p>"ChefAI has completely changed my weeknight dinners! I used to stress about what to make, but now I just type in what I have and get a fantastic recipe. It's like magic!"</p>
            <p class="testimonial-author">- Alex Johnson</p>
        </div>
    </section>

    <!-- 5. Call to Action Section -->
    <section class="section cta">
        <h2 class="section-title">Ready to Revolutionize Your Kitchen?</h2>
        <p>Join thousands of happy cooks and start creating amazing meals today. Your free account is waiting.</p>
        <a href="register.php" class="btn btn-cta">Sign Up for Free</a>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
        <p class="copyright">&copy; 2025 ChefAI. All rights reserved.</p>
    </footer>

    <!-- External JavaScript -->
    <script src="script.js"></script>
</body>
</html>
