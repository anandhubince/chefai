<?php







session_start();



require_once 'db_connection.php'; // This provides $pdo







$error = '';







if ($_SERVER['REQUEST_METHOD'] === 'POST') {



$username = trim($_POST['username']);



$email = trim($_POST['email']);



$password = $_POST['password'];



$password_confirm = $_POST['password_confirm'];







if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {



$error = 'All fields are required. Please fill out the form completely.';



} else if ($password !== $password_confirm) {



$error = 'Passwords do not match. Please try again.';



} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {



$error = 'The email address is not valid. Please enter a correct email.';



} else {





$sql = "SELECT user_id FROM users WHERE username = :username OR email = :email";

$stmt = $pdo->prepare($sql);

$stmt->execute(['username' => $username, 'email' => $email]);



if ($stmt->fetch()) {

 $error = 'That username or email is already in use. Please choose another one.';

} else {

 $password_hash = password_hash($password, PASSWORD_DEFAULT);



 $insert_sql = "INSERT INTO users (username, password_hash, email) VALUES (:username, :password_hash, :email)";

$insert_stmt = $pdo->prepare($insert_sql);

 if ($insert_stmt->execute([

 'username' => $username,

 'password_hash' => $password_hash,

 'email' => $email

])) {

 header('Location: login.php');

 exit;

 } else {

 $error = 'Something went wrong during registration. Please try again later.';

 }

}

}

}



?>





<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    /* Import Google Fonts for a distinct feel */
    @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;700&family=Nunito+Sans:wght@400;600;700&display=swap');

    /* General Body and Font Styles */
    body {
        font-family: 'Nunito Sans', sans-serif; /* Clean, modern body font */
        background: linear-gradient(135deg, #F0F8F6 0%, #D4EDDA 100%); /* Soft, fresh, light green gradient */
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        color: #444; /* Softer dark gray for text */
        line-height: 1.6;
        overflow-x: hidden; /* Prevent horizontal scroll */
        text-rendering: optimizeLegibility; /* Improves font rendering */
    }

    /* Container for the Form */
    .container {
        background-color: #ffffff;
        padding: 50px 40px; /* More padding for spacious feel */
        border-radius: 20px; /* Even more rounded, friendly corners */
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12); /* Deeper, softer shadow for depth */
        width: 100%;
        max-width: 420px; /* Optimal width for readability and design */
        box-sizing: border-box;
        text-align: center;
        position: relative;
        overflow: hidden;
        animation: slideInUp 0.8s ease-out forwards; /* Fun slide-in animation */
        border: 1px solid #e0e0e0; /* Subtle border for definition */
    }

    /* Decorative background elements (subtle "food" or "tech" pattern) */
    .container::before,
    .container::after {
        content: '';
        position: absolute;
        background: rgba(144, 238, 144, 0.1); /* Light green blob */
        border-radius: 50%;
        filter: blur(50px); /* Soft blur for a diffused effect */
        z-index: 0;
    }

    .container::before {
        width: 150px;
        height: 150px;
        top: -60px;
        left: -60px;
    }

    .container::after {
        width: 100px;
        height: 100px;
        bottom: -40px;
        right: -40px;
        background: rgba(255, 223, 186, 0.2); /* Light peach/orange blob */
    }


    /* Heading Style */
    h1 {
        font-family: 'Comfortaa', cursive; /* More playful, rounded font for heading */
        color: #3BB143; /* Vibrant green for ChefAI */
        font-size: 2.8em; /* Larger, more impactful */
        margin-bottom: 35px;
        font-weight: 700;
        letter-spacing: -1.5px; /* Tighter letter spacing for impact */
        position: relative;
        z-index: 1; /* Ensure text is above blobs */
        text-shadow: 1px 1px 3px rgba(0,0,0,0.05); /* Subtle text shadow */
    }

    /* Error Message Styling */
    p.error {
        background-color: #FFEBEE; /* Light red */
        color: #D32F2F; /* Stronger red */
        border: 1px solid #EF9A9A;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 30px;
        font-size: 0.9em;
        font-weight: 600;
        text-align: left;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        position: relative;
        z-index: 1;
    }

    /* Form Group Styling (Label + Input) */
    .form-group {
        margin-bottom: 25px;
        text-align: left;
        position: relative;
        z-index: 1;
    }

    /* Label Styles */
    label {
        display: block;
        margin-bottom: 10px; /* More space for labels */
        font-weight: 600;
        color: #555;
        font-size: 0.95em;
        transition: color 0.3s ease;
    }

    /* Input Field Styles */
    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 16px 20px;
        border: 1px solid #DEDEDE; /* Light, subtle border */
        border-radius: 12px; /* Matches container and button */
        font-size: 1em;
        color: #333;
        background-color: #FAFAFA; /* Slightly off-white background */
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        box-sizing: border-box; /* Crucial */
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #3BB143; /* Vibrant green on focus */
        box-shadow: 0 0 0 4px rgba(59, 177, 67, 0.2); /* Soft, vibrant glow */
        outline: none;
        background-color: #FFFFFF;
    }

    /* Button Styling */
    .btn {
        background: linear-gradient(45deg, #3BB143 0%, #6CC46C 100%); /* Green gradient for button */
        color: white;
        padding: 18px 30px; /* Generous padding */
        border: none;
        border-radius: 12px; /* Consistent roundedness */
        font-size: 1.2em; /* Larger, more inviting text */
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease; /* Smooth transition for all properties */
        width: 100%;
        margin-top: 30px; /* More space above button */
        letter-spacing: 0.8px;
        box-shadow: 0 8px 20px rgba(59, 177, 67, 0.25); /* Stronger shadow */
        position: relative;
        z-index: 1;
        text-transform: uppercase; /* Make it pop a bit */
    }

    .btn:hover {
        background: linear-gradient(45deg, #2E8B34 0%, #5CB85C 100%); /* Darker gradient on hover */
        transform: translateY(-4px) scale(1.01); /* More pronounced lift and slight scale */
        box-shadow: 0 12px 25px rgba(59, 177, 67, 0.35); /* Enhanced shadow on hover */
    }

    .btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(59, 177, 67, 0.1);
    }

    /* Link Styling */
    p {
        font-size: 0.9em;
        margin-top: 35px; /* More space below button */
        color: #777;
        position: relative;
        z-index: 1;
    }

    p a {
        color: #3BB143; /* Matching vibrant green for links */
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s ease, text-decoration 0.3s ease;
    }

    p a:hover {
        color: #2E8B34; /* Darker green on hover */
        text-decoration: underline;
    }

    /* Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 500px) {
        .container {
            margin: 15px;
            padding: 35px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.2em;
            margin-bottom: 30px;
            letter-spacing: -1px;
        }

        .btn {
            padding: 15px 20px;
            font-size: 1.1em;
        }

        .container::before,
        .container::after {
            display: none; /* Hide decorative blobs on very small screens */
        }

        label {
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 14px 18px;
        }
    }

    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ChefAI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Create Your ChefAI Account</h1>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST" novalidate>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
