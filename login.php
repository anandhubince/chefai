<?php

// Start the session to store user data
session_start();

// Include the database connection file. This provides the $pdo object.
require_once 'db_connection.php';

// Initialize an empty variable to hold any error messages
$error = '';

// Check if the form was submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the user input
    $username_or_email = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if the input fields are not empty
    if (empty($username_or_email) || empty($password)) {
        $error = 'Please enter both your username/email and password.';
    } else {
        try {
            // Prepare the SQL query to find a user by either username or email
            $sql = "SELECT user_id, username, password_hash FROM users WHERE username = :username_or_email OR email = :username_or_email";
            $stmt = $pdo->prepare($sql);

            // Bind the parameter to the statement
            $stmt->bindParam(':username_or_email', $username_or_email);

            // Execute the statement
            $stmt->execute();

            // Check if a user was found
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify the submitted password against the stored hashed password
                if (password_verify($password, $user['password_hash'])) {
                    // Password is correct, so store user data in session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];

                    // Redirect the user to their homepage.
                    // This is the correct web path to your user_homepage.php file.
                    header('Location: /ChefAI/User/user_homepage.php');

                    // Terminate the script to prevent further execution after the redirect
                    exit;
                } else {
                    // Incorrect password
                    $error = 'Invalid username or password.';
                }
            } else {
                // No user found with that username or email
                $error = 'Invalid username or password.';
            }
        } catch (PDOException $e) {
            // Catch and display any database errors that occur.
            $error = "Database Error: " . $e->getMessage();
        }
    }
}
// The PDO connection is automatically closed when the script finishes.

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ChefAI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
    /* Import Poppins font from Google Fonts (already in your main style.css) */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* Define your CSS variables (assuming these are in your main style.css, but including for completeness) */
    :root {
        --primary-green: #4CAF50; /* Vibrant Green */
        --primary-green-dark: #3e8e41;
        --secondary-yellow: #FFD700; /* Soft Gold/Yellow Accent */
        --main-white: #ffffff;
        --light-grey-bg: #f8f9fa;
        --dark-text: #2c3e50; /* Darker for headings */
        --light-text: #555555; /* Lighter for body text */
        --border-color: #e0e0e0;
        --shadow-light: rgba(0, 0, 0, 0.05);
        --shadow-medium: rgba(0, 0, 0, 0.1);
    }

    /* Global body and html styles (already in your main style.css) */
    body, html {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background-color: var(--light-grey-bg); /* Use light grey for auth pages */
        color: var(--light-text);
        scroll-behavior: smooth;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Base container styles (assuming you have a .container in main style.css) */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Header (from your main style.css, slightly adapted for context) */
    .main-header {
        position: sticky;
        top: 0;
        left: 0;
        width: 100%;
        background-color: var(--main-white);
        box-shadow: 0 2px 15px var(--shadow-light);
        z-index: 1000;
        padding: 1rem 3rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
    }

    .main-header .header-container { /* Added for better control within a container */
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%; /* Ensure it spans the container */
    }

    .logo {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary-green);
        text-decoration: none;
        letter-spacing: -1px;
    }

    .main-nav a {
        text-decoration: none;
        color: var(--dark-text);
        font-weight: 500;
        margin-left: 2rem;
        transition: color 0.3s ease, transform 0.3s ease;
        position: relative;
    }

    .main-nav a::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        display: block;
        margin-top: 5px;
        right: 0;
        background: var(--primary-green);
        transition: width 0.3s ease;
        -webkit-transition: width 0.3s ease;
    }

    .main-nav a:hover::after {
        width: 100%;
        left: 0;
        background: var(--primary-green);
    }

    .main-nav a:hover {
        color: var(--primary-green);
        transform: translateY(-2px);
    }

    /* --- Login Page Specific Styles --- */

    .auth-page {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 120px); /* Adjust height to account for header/footer */
        padding: 3rem 1rem; /* Padding for mobile views */
        background-color: var(--light-grey-bg); /* Consistent with body */
    }

    .login-card {
        background-color: var(--main-white);
        border-radius: 18px; /* Slightly more rounded corners */
        box-shadow: 0 15px 40px var(--shadow-medium); /* More prominent, soft shadow */
        padding: 3.5rem 3rem; /* Generous padding */
        width: 100%;
        max-width: 450px; /* Constrain width for a focused look */
        text-align: center;
        box-sizing: border-box; /* Include padding in width */
        position: relative;
        overflow: hidden; /* For any background elements if added later */
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: -30px;
        left: -30px;
        width: 100px;
        height: 100px;
        background: var(--secondary-yellow);
        border-radius: 50%;
        opacity: 0.1;
        z-index: 0;
    }

    .login-card::after {
        content: '';
        position: absolute;
        bottom: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        background: var(--primary-green);
        border-radius: 50%;
        opacity: 0.08;
        z-index: 0;
    }

    .card-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 2rem;
        position: relative; /* For z-index over pseudo-elements */
        z-index: 1;
    }

    .error-message {
        background-color: #ffebee; /* Light red */
        color: #c62828; /* Dark red */
        border: 1px solid #ef9a9a; /* Medium red */
        padding: 0.8rem 1.2rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        text-align: left;
        position: relative;
        z-index: 1;
    }

    .login-form {
        text-align: left; /* Align form elements to the left */
        position: relative;
        z-index: 1;
    }

    .form-group {
        margin-bottom: 1.7rem; /* More spacing between form groups */
    }

    .form-group label {
        display: block;
        font-size: 1rem;
        color: var(--dark-text);
        margin-bottom: 0.6rem;
        font-weight: 500;
    }

    .form-group input[type="text"],
    .form-group input[type="password"] {
        width: 100%;
        padding: 1rem 1.2rem;
        border: 1px solid var(--border-color);
        border-radius: 10px; /* Slightly more rounded inputs */
        font-size: 1.1rem;
        color: var(--dark-text);
        background-color: var(--light-grey-bg); /* Slightly grey background for inputs */
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        box-sizing: border-box; /* Crucial for consistent width */
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="password"]:focus {
        border-color: var(--primary-green);
        outline: none;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2); /* Green focus halo */
        background-color: var(--main-white); /* White background on focus */
    }

    .login-btn {
        width: 100%;
        padding: 1.2rem 2.5rem;
        border-radius: 50px; /* Pill shape */
        font-size: 1.2rem;
        font-weight: 600;
        cursor: pointer;
        background-color: var(--primary-green);
        color: var(--main-white);
        border: none;
        transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3); /* Green tinted shadow */
        margin-top: 1rem; /* Space above button */
    }

    .login-btn:hover {
        background-color: var(--primary-green-dark);
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(76, 175, 80, 0.4);
    }

    .login-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(76, 175, 80, 0.1);
    }

    .register-link-text {
        margin-top: 2rem; /* Space above register link */
        font-size: 1rem;
        color: var(--light-text);
        position: relative;
        z-index: 1;
    }

    .register-link-text .text-link {
        color: var(--primary-green);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease, text-decoration 0.3s ease;
    }

    .register-link-text .text-link:hover {
        color: var(--primary-green-dark);
        text-decoration: underline;
    }

    /* --- Footer (from your main style.css, slightly adapted for context) --- */
    .main-footer {
        background-color: var(--dark-text); /* Deep neutral grey/blue */
        color: var(--main-white);
        padding: 2rem 2rem; /* Reduced padding for a smaller footer */
        text-align: center;
        font-size: 0.9rem;
    }

    .main-footer .footer-container { /* Added for better control within a container */
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem; /* Space between copyright and links */
    }

    .footer-links {
        display: flex; /* Arrange links horizontally */
        gap: 1.5rem; /* Space between footer links */
    }

    .footer-links a {
        color: var(--main-white);
        text-decoration: none;
        transition: color 0.3s ease;
        font-weight: 400;
    }

    .footer-links a:hover {
        color: var(--secondary-yellow);
    }

    .copyright {
        color: #bdc3c7;
    }

    /* --- Responsive Adjustments --- */
    @media (max-width: 768px) {
        .main-header {
            padding: 1rem 1.5rem;
        }
        .main-header .header-container {
            flex-direction: column;
            align-items: flex-start;
        }
        .main-nav {
            margin-top: 1rem;
            width: 100%;
            display: flex;
            justify-content: center; /* Center nav links on smaller screens */
        }
        .main-nav a {
            margin: 0 1rem; /* Adjust margin for mobile nav */
        }

        .auth-page {
            padding: 2rem 1rem;
        }

        .login-card {
            padding: 2.5rem 1.5rem;
            max-width: 90%; /* Allow wider on smaller screens */
            box-shadow: 0 10px 25px var(--shadow-light); /* Less intense shadow */
        }

        .card-title {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 0.9rem;
        }

        .form-group input {
            padding: 0.8rem 1rem;
            font-size: 1rem;
        }

        .login-btn {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        .register-link-text {
            font-size: 0.9rem;
        }

        .main-footer {
            padding: 1.5rem 1rem;
        }
        .main-footer .footer-container {
            gap: 0.75rem;
        }
        .footer-links {
            flex-direction: column; /* Stack footer links vertically */
            gap: 0.5rem;
        }
    }

    @media (max-width: 480px) {
        .main-nav a {
            margin: 0 0.8rem;
        }
        .auth-page {
            padding: 1.5rem 0.5rem;
        }
        .login-card {
            padding: 2rem 1rem;
        }
        .card-title {
            font-size: 1.6rem;
        }
        .login-btn {
            font-size: 1rem;
            padding: 0.9rem 1.5rem;
        }
    }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container header-container">
            <a href="index.php" class="logo">ChefAI</a>
            <nav class="main-nav">
                <a href="index.php" class="nav-link">Home</a>
            </nav>
        </div>
    </header>

    <main class="auth-page">
        <div class="login-card">
            <h1 class="card-title">Login to ChefAI</h1>
            <?php if (!empty($error)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Username or Email</label>
                    <input type="text" id="username" name="username" required autocomplete="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary login-btn">Login</button>
            </form>
            <p class="register-link-text">Don't have an account? <a href="register.php" class="text-link">Register here</a>.</p>
        </div>
    </main>

    <footer class="main-footer">
        <div class="container footer-container">
            <p>&copy; <?php echo date("Y"); ?> ChefAI. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>
</body>
</html>
